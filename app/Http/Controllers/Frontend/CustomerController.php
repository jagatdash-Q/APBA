<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerPasswordReset;
use App\Models\CustomerSubscription;
use App\Models\DefaultMembership;
use App\Models\EventProgramRegistration;
use App\Models\EventRegistration;
use App\Models\EventRegistrationOptional;
use App\Models\MembershipPackage;
use App\Models\Nomination;
use App\Models\NominationContent;
use App\Models\Payment;
use App\Models\ReminderMail;
use App\Models\SurveyActivity;
use App\Models\SurveyRegistration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Voting;
use App\Models\VotingContent;
use App\Traits\Common;

class CustomerController extends Controller
{
    use Common;
    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'profile_pic' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'The :attribute does not match with the image.'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $postData = $request->only('profile_pic');
        $file = $postData['profile_pic'];
        $fileArray = array('profile_pic' => $file);
        $rules = array(
            'profile_pic' => 'mimes:jpeg,jpg,png,gif|required|max:200'
        );
        $validator = Validator::make($fileArray, $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorMessage', 'The profile pic may not be greater than 200 KB.');
        }

        $profile_pic = time() . '.' . $request->profile_pic->extension();

        $packages = MembershipPackage::where('subscription_type', 'sub')->where('id', $request->package_id)->first();
        if ($packages == null)
            return redirect()->back()->with('errorMessage', 'Please choose any of the memberships package.')->withInput();

        // Check customer exist or not 

        $is_customer_exist = Customer::where('email', $request->email)->first();
        if ($is_customer_exist != null) {
            return redirect()->back()->with('errorMessage', 'Email already exist')->withInput();
        }
        $token = Str::uuid()->toString();

        $is_customer_create = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->full_name,
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'is_verify_email' => '0',
            'registered_on' => now(),
            'email_token' => $token,
            'current_subscription_status' => 'p',
            'active_subscription' => $packages->id,
            // 'active_subscription_expired_on' => Carbon::now()->addYear(),
            'active_subscription_expired_on' => null,
            'nomination' => 'yes',
            'social_media_link' => $request->social_media_link,
            'profile_pic' => $profile_pic,
        ]);

        if ($is_customer_create) {
            $request->profile_pic->move(public_path() . '/uploads/profile_pic', $profile_pic);
            // send email
            try {
                $details = [
                    'name' => $request->full_name,
                    'mail' => $request->email,
                    'activate_link' =>  url('customer/account/confirm?token=' . $token),
                ];
                Mail::to($request->email)->send(new \App\Mail\CustomerRegistrationMail($details));

                // Payment Integration

                return $this->processTransaction($is_customer_create->id, $packages->membership_price, $request->payment_for, $packages->id, null);
            } catch (Exception $e) {
                Log::info('Error in sending activation email :-' . $e->getMessage());
                return redirect()->back()->with('errorMessage', 'Something went wrong!, please contact with admin.');
            }
        }
    }

    public function customerRegistrationPage(Request $request)
    {
        $packages = MembershipPackage::where('subscription_type', 'sub')->get();
        $country = Country::where('status', '1')->get();
        if (count($packages)) {
            return view('frontend.customer_register', compact('country', 'packages'));
        } else {
            abort(404);
        }
    }

    public function membershipRegister(Request $request, $uid)
    {
        if ($uid == '') {
            abort(404);
        } else {
            $is_member_ship_exist = MembershipPackage::where('uid', $uid)->first();
            if ($is_member_ship_exist == null) {
                abort(404);
            } else {
                $country = Country::where('status', '1')->get();
                return view('frontend.membership_register', compact('country', 'is_member_ship_exist'));
            }
        }
    }

    public function verifyCustomerEmail(Request $request)
    {
        if (!isset($_GET['token']))
            return redirect('/')->with('errorMessage', 'Invalid email token');
        $token = $_GET['token'];
        $userdetails = Customer::where('email_token', $token)->first();
        if ($token == '') {
            return redirect('/')->with('errorMessage', 'Invalid email token');
        }

        if ($userdetails == NULL) {
            return redirect('/')->with('errorMessage', 'Customer does not exist');
        } else {
            if ($userdetails->is_verify == "1") {
                return redirect('/')->with('doneMessage', 'Email Already Verified');
            } else {
                $form_data = array(
                    'email_verified_on' => now(),
                    'is_verify_email' => "1",
                );
                Customer::whereId($userdetails->id)->update($form_data);
                return redirect('/')->with('doneMessage', 'Email Verified Successfully');
            }
        }
    }


    public function resetCustomerPassword(Request $request)
    {
        $token = $_GET['token'];
        $password_reset_details = CustomerPasswordReset::where('password_reset_token', $token)->first();
        if ($token == '') {
            return redirect('/')->with('errorMessage', 'Invalid password reset link');
        }
        if ($password_reset_details == NULL) {
            return redirect('/')->with('errorMessage', 'Invalid password reset link');
        } else {
            // Check 
            $time_diff = Carbon::parse($password_reset_details->password_reset_link_sent_on)->diffInMinutes(Carbon::now());
            if ($time_diff > 30) {
                return redirect('/')->with('errorMessage', 'Reset password link has been expired');
            }
            return view('frontend.customer.password_reset', compact('password_reset_details'));
        }
    }

    public function updateCustomerPassword(Request $request)
    {
        $token = $request->password_reset_token;
        $is_valid_token = CustomerPasswordReset::where('password_reset_token', $token)->first();
        if ($is_valid_token != null) {
            $arr = array(
                'password' => Hash::make($request->password),
            );
            Customer::whereId($is_valid_token->customer_id)->update($arr);
            CustomerPasswordReset::whereId($is_valid_token->id)->update([
                'password_reset_on' => now(),
            ]);
        }

        return redirect('/')->with('doneMessage', 'Password updated successfully');
    }


    public function customerDashboard(Request $request)
    {
        // Get current subscription details
        $customer_details = Customer::with(['getActiveSubscriptionDetails', 'getEventRegistration'])->whereId(Auth::guard('customer')->user()->id)->first();
        $packages = MembershipPackage::where('subscription_type', 'sub')->get();
        $country = Country::where('status', '1')->get();
        $check_nomination = Nomination::with('getNominationPosition')->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->first();
        $check_election = Voting::whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->first();
        $election_content = VotingContent::first();
        $nomination_content = NominationContent::first();
        return view('frontend.customer.dashboard', compact('country', 'customer_details', 'packages', 'check_nomination', 'election_content', 'check_election', 'nomination_content'));
    }
    public function customerProfileUpdate(Request $request)
    {
        try {
            $check_customer = Customer::where('is_verify_email', '1')->where('id', Auth::guard('customer')->user()->id)->first();
            if ($check_customer == null) {
                return redirect()->back()->with('errorMessage', 'Profile not found!, Please contact with admin.');
            }
            if ($request->password != null) {
                if (Hash::check($request->password, $check_customer->password)) {
                    return redirect()->back()->with('errorMessage', 'You\'ve used this Password before. Try again with a different Password.');
                }
            }
            if (request()->hasFile('profile_pic')) {
                $postData = $request->only('profile_pic');
                $file = $postData['profile_pic'];
                $fileArray = array('profile_pic' => $file);
                $rules = array(
                    'profile_pic' => 'mimes:jpeg,jpg,png,gif|required|max:200' // max 10000kb
                );
                $validator = Validator::make($fileArray, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorMessage', 'The profile pic may not be greater than 200 KB.');
                }

                $profile_pic = time() . '.' . $request->profile_pic->extension();
            } else {
                $profile_pic = null;
            }

            $check_customer->first_name = $request->first_name;
            $check_customer->last_name = $request->last_name;
            $check_customer->country = $request->country;
            $check_customer->user_name = $request->full_name;
            $check_customer->social_media_link = $request->social_media_link;

            if ($profile_pic != null)
                $check_customer->profile_pic = $profile_pic;

            if ($request->password != null)
                $check_customer->password = Hash::make($request->password);
            $check_customer->save();
            // if (request()->hasFile('profile_pic')) {
            //     if ($check_customer->save()) {
            //         unlink(public_path() . '/uploads/profile_pic/' . $check_customer->profile_pic);
            //         $request->profile_pic->move(public_path() . '/uploads/profile_pic', $profile_pic);
            //     }
            // }

            if (request()->hasFile('profile_pic')) {
                if ($check_customer->save()) {
                    $oldProfilePicPath = public_path() . '/uploads/profile_pic/' . $check_customer->profile_pic;
                    
                    // Check if the file exists before unlinking
                    if (file_exists($oldProfilePicPath)) {
                        unlink($oldProfilePicPath);
                    }
                    
                    // Move the new profile picture
                    $request->profile_pic->move(public_path() . '/uploads/profile_pic', $profile_pic);
                }
            }
            return redirect()->back()->with('doneMessage', 'Profile updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function processTransaction($id, $amount, $payment_for, $subscription_id, $event_reg_id)
    {
        $payment_id = null;
        // if ($payment_for == "pay now" || $payment_for == "renew" || $payment_for == "upgrade") {
        //     $customer_data = Customer::where('id', $id)->first();
        //     if ($customer_data != null) {
        //         $customer_data->current_subscription_status = 'p';
        //         $customer_data->active_subscription = $subscription_id;
        //         $customer_data->active_subscription_expired_on = null;
        //         $customer_data->save();
        //     }
        // }

        $payment = new Payment();
        $payment->customer_id = $id;
        $payment->subscription_id = $subscription_id;
        $payment->event_registartion_id = $event_reg_id;
        $payment->payment_status = 'pending';
        $payment->total_amount = $amount;
        $payment->payment_for = $payment_for;
        $payment->payment_mode = "online";
        $payment->response = null;
        $payment->save();
        $payment_id = $payment->id;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction', ['id' => $id, 'payment_id' => $payment_id]),
                "cancel_url" => route('cancelTransaction', ['payment_id' => $payment_id]),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "SGD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            if ($payment_for == "pay now" || $payment_for == "renew" || $payment_for == "upgrade" || $payment_for == "event registration" || $payment_for == "retry event registartion") {
                return redirect()
                    ->back()
                    ->with('errorMessage', 'Something went wrong!, please try again later.');
            } else {
                return redirect()
                    ->back()
                    ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email but subscription not done.');
            }
        } else {
            if ($payment_for == "pay now" || $payment_for == "renew" || $payment_for == "upgrade" || $payment_for == "event registration" || $payment_for == "retry event registartion") {
                return redirect()
                    ->back()
                    ->with('errorMessage', 'Something went wrong!, please try again later.');
            } else {
                return redirect()
                    ->back()
                    ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email but' . $response['message']);
            }
        }
    }

    public function successTransaction(Request $request)
    {
        if (!isset($request['token']) || $request['token'] == null)
            return redirect()
                ->back()
                ->with('errorMessage', 'Something went wrong');
        $payment_details = null;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if ($request['payment_id'] != null)
            $payment_details =  Payment::where('id', $request['payment_id'])->first();

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            if ($payment_details->payment_for == "pay now" || $payment_details->payment_for == "renew" || $payment_details->payment_for == "upgrade" || $payment_details->payment_for == "membership registration" || $payment_details->payment_for == "customer registration") {
                $subscription_expired_on = null;
                $get_plan = MembershipPackage::where('subscription_type', 'sub')->where('id', $payment_details->subscription_id)->first();
                if ($get_plan != null) {
                    $get_plan->membership_plan;
                    if ($get_plan->membership_plan == "yearly")
                        $subscription_expired_on = Carbon::now()->addYear();
                    else
                        $subscription_expired_on = "2219-07-21";
                }

                $get_customer = Customer::where('id', $request['id'])->first();
                $get_customer->current_subscription_status = 'a';
                $get_customer->active_subscription = $payment_details->subscription_id;
                $get_customer->active_subscription_expired_on = $subscription_expired_on;
                $get_customer->save();

                $customer_subscriptions = new CustomerSubscription();
                $customer_subscriptions->membership_id = $payment_details->subscription_id;
                $customer_subscriptions->customer_id = $request['id'];
                $customer_subscriptions->amount = $payment_details->total_amount;
                $customer_subscriptions->subscription_in = $payment_details->payment_for;
                $customer_subscriptions->subscription_expired_on = $subscription_expired_on;
                $customer_subscriptions->save();

                // Membership mail
                $details = [
                    'name' => $get_customer->first_name,
                    'membership_type' => $get_plan->membership_name,
                    'end_date' => Carbon::parse($subscription_expired_on)->format('d F Y'),
                    'user_name' => $get_customer->user_name,
                    'total_amount' => $payment_details->total_amount,
                    'payment_mode' => ucwords($payment_details->payment_mode),
                ];
                Mail::to($get_customer->email)->send(new \App\Mail\MembershipSubscriptionMail($details));
            }

            if ($payment_details != null) {
                $payment_details->payment_status = 'success';
                $payment_details->response = json_encode($response);
                $payment_details->save();

                if ($payment_details->event_registartion_id != null) {
                    EventRegistration::where('id', $payment_details->event_registartion_id)->update(['payment_status' => 'success']);
                }


                if ($payment_details->payment_for == "pay now" || $payment_details->payment_for == "renew" || $payment_details->payment_for == "upgrade" || $payment_details->payment_for == "event registration" || $payment_details->payment_for == "retry event registartion") {

                    if ($payment_details->payment_for != "event registration" || $payment_details->payment_for != "retry event registartion")
                        // clear sent subscription reminder mail record
                        ReminderMail::where('customer_id', $request['id'])->delete();

                    return redirect()
                        ->back()
                        ->with('doneMessage', ucwords($payment_details->payment_for) . ' Successfully Completed.');
                } else {
                    return redirect()
                        ->back()
                        ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email.');
                }
            }
            return redirect()
                ->back()
                ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email.');
        } else {


            if ($payment_details != null) {
                $payment_details->payment_status = 'failed';
                $payment_details->response = json_encode($response);
                $payment_details->save();

                if ($payment_details->event_registartion_id != null) {
                    EventRegistration::where('id', $payment_details->event_registartion_id)->update(['payment_status' => 'failed']);
                }


                if ($payment_details->payment_for == "pay now" || $payment_details->payment_for == "renew" || $payment_details->payment_for == "upgrade" || $payment_details->payment_for == "event registration" || $payment_details->payment_for == "retry event registartion") {
                    return redirect()
                        ->back()
                        ->with('errorMessage', 'Something went wrong!, please try again later.');
                } else {
                    return redirect()
                        ->back()
                        ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email but subscription not done.');
                }
            }

            return redirect()
                ->back()
                ->with('doneMessage', 'You have successfully registered , please activate your account by activation link sent to email but subscription not done.');
        }
    }

    public function cancelTransaction(Request $request)
    {
        $payment_details = null;
        if ($request['payment_id'] != null)
            $payment_details =  Payment::where('id', $request['payment_id'])->first();

        if ($payment_details != null) {
            $payment_details->payment_status = 'cancel';
            $payment_details->response = null;
            $payment_details->save();

            if ($payment_details->event_registartion_id != null)
                EventRegistration::where('id', $payment_details->event_registartion_id)->update(['payment_status' => 'cancel']);
            if ($payment_details->payment_for == "pay now" || $payment_details->payment_for == "renew" || $payment_details->payment_for == "upgrade" || $payment_details->payment_for == "event registration" || $payment_details->payment_for == "retry event registartion") {
                return redirect()
                    ->back()
                    ->with('errorMessage', 'You have cancelled the transaction.');
            } else {
                return redirect()
                    ->back()
                    ->with('errorMessage', 'You have successfully registered , please activate your account by activation link sent to email but You have cancelled the transaction.');
            }
        }
        return redirect()
            ->back()
            ->with('errorMessage', 'You have successfully registered , please activate your account by activation link sent to email but You have cancelled the transaction.');
    }
    public function upgradePayment(Request $request)
    {
        $packages = MembershipPackage::where('subscription_type', 'sub')->where('id', $request->subscription_id)->first();
        if ($packages != null) {
            return $this->processTransaction(Auth::guard('customer')->user()->id, $packages->membership_price, $request['payment_for'], $request->subscription_id, null);
        }
    }
    public function customerSurvey($program_uuid)
    {
        $check_survey = 0;
        $event_program = EventProgramRegistration::with('getProgramDetails', 'getEventRegDetails')->where('uuid', $program_uuid)->first();
        if ($event_program == null)
            abort(404);

        // if ($event_program->survey == 'yes')
        //     abort(404);

        // if (isset($event_program->getEventDetails)) {
        //     $current_date = Carbon::now()->startOfDay();
        //     $end_date = Carbon::parse($event_program->getEventDetails->end_date)->startOfDay();
        //     if ($current_date->lt($end_date)) {
        //         abort(404);
        //     }
        // }
        if (isset($event_program->getProgramDetails)) {
            if ($event_program->getProgramDetails->survey == 'yes' && $event_program->getProgramDetails->survey_activity_uuid != null) {
                $check_survey = 1;
            }
        }
        if (isset($event_program->getEventRegDetails)) {
            if ($event_program->getEventRegDetails->payment_status != 'success')
                $check_survey = 0;
        }
        if ($check_survey == 0)
            abort(404);
        $survey_reg = SurveyRegistration::where('event_program_registration_uuid', $program_uuid)->first();
        return view('frontend.customer.survey_certification', compact('event_program', 'survey_reg'));
    }
    public function customerOptionalSurvey($optional_uuid)
    {
        $check_survey = 0;
        $optional_program = EventRegistrationOptional::with('getOptionalDetails', 'getEventRegDetails')->where('uuid', $optional_uuid)->first();
        if ($optional_program == null)
            abort(404);

        if (isset($optional_program->getOptionalDetails)) {
            if ($optional_program->getOptionalDetails->survey == 'yes' && $optional_program->getOptionalDetails->survey_activity_uuid != null) {
                $check_survey = 1;
            }
        }
        if (isset($optional_program->getEventRegDetails)) {
            if ($optional_program->getEventRegDetails->payment_status != 'success')
                $check_survey = 0;
        }
        if ($check_survey == 0)
            abort(404);
        $survey_reg = SurveyRegistration::where('event_registration_optional_uuid', $optional_uuid)->first();
        return view('frontend.customer.optional_survey_certification', compact('optional_program', 'survey_reg'));
    }
    public function surveyDetails(Request $request)
    {
        if ($request->ajax()) {
            if ($request->reg_type == "program") {
                $event_reg = EventProgramRegistration::with('getProgramDetails')->where('event_registration_uuid', $request->reg_uuid)->get();
                return $event_reg;
            } else {
                $event_reg_opt = EventRegistrationOptional::with('getOptionalDetails', 'getEventRegDetails')->where('event_registration_id', $request->reg_uuid)->get();
                return $event_reg_opt;
            }
        }
    }
    public function submitSurvey(Request $request)
    {
        if ($request->ajax()) {
            try {
                $type = null;
                $check_type = EventProgramRegistration::where('uuid', $request->event_program_registration_uuid)->with('getEventRegDetails')->first();
                if ($check_type != null) {
                    if (isset($check_type->getEventRegDetails)) {
                        if ($check_type->getEventRegDetails->customer_id == null)
                            $type = 'Guest';
                        else
                            $type = 'Member';
                    }
                }
                // $survey_reg = new SurveyRegistration();
                $survey_reg = SurveyRegistration::firstOrNew(['event_program_registration_uuid' => $request->event_program_registration_uuid]);
                // $survey_reg->event_program_registration_uuid = $request->event_program_registration_uuid;
                $survey_reg->fullname = $request->fullname;
                $survey_reg->organization = $request->organization;
                $survey_reg->email = $request->email;
                $survey_reg->content_material = $request->content_material;
                $survey_reg->speaker_knowledge = $request->speaker_knowledge;
                $survey_reg->trainer_presentation = $request->trainer_presentation;
                $survey_reg->q_a_session = $request->q_a_session;
                $survey_reg->overall_delivery = $request->overall_delivery;
                $survey_reg->conference_content = $request->conference_content;
                $survey_reg->conference_relevant = $request->conference_relevant;
                $survey_reg->future_conference = $request->future_conference;
                $survey_reg->feedback = $request->feedback;
                $survey_reg->type = $type;

                if ($request->type == '0') {
                    $survey_reg->survey_activity_uuid = $request->survey_activity_uuid;
                    $survey_reg->survey_url = url('/') . "/customer-survey/" . $request->event_program_registration_uuid;
                    $survey_reg->uuid = Str::uuid()->toString();
                    $survey_reg->certificate_sent = 'no';
                    $survey_reg->certificate = null;
                }
                $survey_reg->save();
                $this->sent_certificate($survey_reg->uuid);
                if ($request->type == '0') {
                    if ($survey_reg->save())
                        EventProgramRegistration::where('uuid', $request->event_program_registration_uuid)->update(['survey' => 'yes']);
                    return ['success', "Survey form submitted successfully."];
                } else
                    return ['success', "Survey form updated successfully."];
            } catch (\Throwable $th) {
                return ['error', "Something went wrong! Please try again later."];
            }
        }
    }

    public function nonMemberSurvey($survey_uuid)
    {
        $survey_reg = null;
        $survey_activity = SurveyActivity::where('uuid', $survey_uuid)->with('getEventOptional', 'getEventProgram')->first();
        if ($survey_activity == null)
            abort(404);

        // $event_name=;
        // if (!isset($survey_activity->getEventProgram)){

        // }else{

        // }
        // abort(404);

        return view('frontend.customer.non_member_survey_certification', compact('survey_activity', 'survey_reg'));
    }

    public function nonMemberSubmitSurvey(Request $request)
    {
        if ($request->ajax()) {
            try {
                $survey_reg = new SurveyRegistration();
                $survey_reg->uuid = Str::uuid()->toString();
                $survey_reg->survey_activity_uuid = $request->survey_activity_uuid;
                $survey_reg->event_program_registration_uuid = null;
                $survey_reg->fullname = $request->fullname;
                $survey_reg->organization = $request->organization;
                $survey_reg->email = $request->email;
                $survey_reg->content_material = $request->content_material;
                $survey_reg->speaker_knowledge = $request->speaker_knowledge;
                $survey_reg->trainer_presentation = $request->trainer_presentation;
                $survey_reg->q_a_session = $request->q_a_session;
                $survey_reg->overall_delivery = $request->overall_delivery;
                $survey_reg->conference_content = $request->conference_content;
                $survey_reg->conference_relevant = $request->conference_relevant;
                $survey_reg->future_conference = $request->future_conference;
                $survey_reg->feedback = $request->feedback;
                $survey_reg->survey_url = null;
                $survey_reg->certificate_sent = 'no';
                $survey_reg->certificate = null;
                $survey_reg->type = 'Non Member';
                $survey_reg->save();
                $this->sent_certificate($survey_reg->uuid);
                return ['success', "Survey form submitted successfully."];
            } catch (\Throwable $th) {
                return ['error', "Something went wrong! Please try again later."];
            }
        }
    }
    public function optionalSubmitSurvey(Request $request)
    {
        if ($request->ajax()) {
            try {
                $type = null;
                $check_type = EventRegistrationOptional::where('uuid', $request->event_registration_optional_uuid)->with('getEventRegDetails')->first();

                if ($check_type != null) {
                    if (isset($check_type->getEventRegDetails)) {
                        if ($check_type->getEventRegDetails->customer_id == null)
                            $type = 'Guest';
                        else
                            $type = 'Member';
                    }
                }

                $survey_reg = SurveyRegistration::firstOrNew(['event_registration_optional_uuid' => $request->event_registration_optional_uuid]);

                $survey_reg->fullname = $request->fullname;
                $survey_reg->organization = $request->organization;
                $survey_reg->email = $request->email;
                $survey_reg->content_material = $request->content_material;
                $survey_reg->speaker_knowledge = $request->speaker_knowledge;
                $survey_reg->trainer_presentation = $request->trainer_presentation;
                $survey_reg->q_a_session = $request->q_a_session;
                $survey_reg->overall_delivery = $request->overall_delivery;
                $survey_reg->conference_content = $request->conference_content;
                $survey_reg->conference_relevant = $request->conference_relevant;
                $survey_reg->future_conference = $request->future_conference;
                $survey_reg->feedback = $request->feedback;
                $survey_reg->type = $type;

                if ($request->type == '0') {
                    $survey_reg->survey_activity_uuid = $request->survey_activity_uuid;
                    $survey_reg->survey_url = url('/') . "/customer-optional-survey/" . $request->event_registration_optional_uuid;
                    $survey_reg->uuid = Str::uuid()->toString();
                    $survey_reg->certificate_sent = 'no';
                    $survey_reg->certificate = null;
                }
                $survey_reg->save();
                // $this->sent_certificate($survey_reg->uuid);
                if ($request->type == '0') {
                    if ($survey_reg->save())
                        EventRegistrationOptional::where('uuid', $request->event_registration_optional_uuid)->update(['survey' => 'yes']);
                    return ['success', "Survey form submitted successfully."];
                } else
                    return ['success', "Survey form updated successfully."];
            } catch (\Throwable $th) {
                return ['error', "Something went wrong! Please try again later."];
            }
        }
    }
}
