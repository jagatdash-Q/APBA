<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ExportMember;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Validator;
use App\Imports\CustomersImport;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerNomination;
use App\Models\CustomerSubscription;
use App\Models\CustomerVoting;
use App\Models\MembershipPackage;
use App\Models\NominationPosition;
use App\Models\Payment;
use App\Models\VotingPosition;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function uploadCustomers(Request $request)
    {
        if (!Auth::user()->hasPermission('member_management-create')) {
            abort(403);
        }
        ini_set("memory_limit", -1);
        ini_set('max_execution_time', '0');
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->has('file')) {
            $file = $request->file('file');
            $fileName = rand() . '.' . $file->extension();
            $file->move(public_path('uploads/media'), $fileName);
            $data = Excel::import(new CustomersImport, public_path('uploads/media/' . $fileName));
            return redirect()->back()->with('doneMessage', 'Excel Data Imported successfully.');
        } else {
            return redirect()->back()->with('errorMessage', 'Please choose file for upload customers details.');
        }
    }
    public function createMember()
    {
        if (!Auth::user()->hasPermission('member_management-create')) {
            abort(403);
        }
        $country = Country::get();
        $packages = MembershipPackage::get();
        return view('dashboard.customer-manager.create-member', ['country' => $country, 'packages' => $packages]);
    }
    public function storeMember(Request $request)
    {
        if (!Auth::user()->hasPermission('member_management-create')) {
            abort(403);
        }
        try {
            $packages = MembershipPackage::where('id', $request->package)->first();
            if ($packages == null) {
                return redirect()->back()->with('errorMessage', 'Please choose any of the memberships package.')->withInput();
            }

            $is_customer_exist = Customer::where('email', $request->email)->first();
            if ($is_customer_exist != null) {
                return redirect()->back()->with('errorMessage', 'Email already exist')->withInput();
            }
            $token = Str::uuid()->toString();

            if (request()->hasFile('profile_pic')) {
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
            } else {
                $profile_pic = null;
            }



            $customer = new Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->user_name = $request->full_name;
            $customer->email = $request->email;
            $customer->country = $request->country;
            $customer->password = Hash::make($request->password);
            $customer->is_verify_email = '0';
            $customer->registered_on = now();
            $customer->email_token = $token;
            $customer->current_subscription_status = 'p';
            $customer->is_term_accept = 'y';
            $customer->created_by = Auth::id();
            $customer->nomination = $request->nomination;
            $customer->profile_pic = $profile_pic;
            $customer->social_media_link = $request->social_media_link;
            $customer->save();
            if ($customer->save()) {
                if ($profile_pic!=null) {
                    $request->profile_pic->move(public_path() . '/uploads/profile_pic', $profile_pic);
                }
                
                
                $details = [
                    'name' => $request->full_name,
                    'mail' => $request->email,
                    'activate_link' =>  url('customer/account/confirm?token=' . $token),
                ];
                Mail::to($request->email)->send(new \App\Mail\CustomerRegistrationMail($details));
                $payment = new Payment();
                $payment->customer_id = $customer->id;
                $payment->subscription_id = $request->package;
                $payment->event_registartion_id = null;
                $payment->payment_status = 'success';
                $payment->total_amount = $packages->membership_price;
                $payment->payment_for = 'admin member registration';
                $payment->payment_mode = $request->payment_mode;
                $payment->response = null;
                $payment->save();

                if ($payment->save()) {
                    $subscription_expired_on = $packages->membership_plan == "yearly" ? Carbon::now()->addYear() : "2219-07-21";
                    $customer_subscriptions = new CustomerSubscription();
                    $customer_subscriptions->membership_id = $request->package;
                    $customer_subscriptions->customer_id = $customer->id;
                    $customer_subscriptions->amount = $packages->membership_price;
                    $customer_subscriptions->subscription_in = 'admin member registration';
                    $customer_subscriptions->subscription_expired_on = $subscription_expired_on;
                    $customer_subscriptions->save();
                    $customer->current_subscription_status = 'a';
                    $customer->active_subscription = $request->package;
                    $customer->active_subscription_expired_on = $subscription_expired_on;
                    $customer->save();
                    // Membership mail
                    $details = [
                        'name' => $request->first_name,
                        'membership_type' => $packages->membership_name,
                        'end_date' => Carbon::parse($subscription_expired_on)->format('d F Y'),
                        'user_name' => $request->full_name,
                        'total_amount' => $packages->membership_price,
                        'payment_mode' => ucwords($request->payment_mode),
                    ];
                    try {
                        Mail::to($request->email)->send(new \App\Mail\MembershipSubscriptionMail($details));
                    } catch (\Throwable $th) {
                        info('Membership Upgrade/Registration Mail Error Log: ' . $th->getMessage());
                    }
                }
            }
            return redirect()->back()->with('doneMessage', 'Member register successfully.');
        } catch (Exception $e) {
            Log::info('Error in member registration :-' . $e->getMessage());
            return redirect()->back()->with('errorMessage', 'Something went wrong! please try again.');
        }
    }
    public function memberDashboard(Request $request)
    {
        if (!Auth::user()->hasPermission('member_management-read')) {
            abort(403);
        }


        $search_customer = [];
        $all_customer = Customer::all();
        if (count($all_customer) > 0) {
            foreach ($all_customer as $key => $cust) {
                $search_customer[$key] = array(
                    'id' => $cust->id,
                    'user_name' => $cust->user_name,
                );
            }
        }
        $total_amount = 0;
        $years = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->pluck('year');
        $members = Customer::query();
        $members = $members->with(['getActiveSubscriptionDetails']);
        if (!$request->has('restore') && $request->has('filter')) {
            if ($request->subscription_status != null) {
                $members = $members->where('current_subscription_status', $request->subscription_status);
            }
            if ($request->year != null) {
                $members = $members->whereYear('created_at', $request->year);
            }
        }

        if ($request->has('export')) {
            return Excel::download(new ExportMember($request->all()), 'member.xlsx');
        }

        if ($request->ajax()) {
            if ($request->search != null) {
                $search = $request->search;
                $matching_ids = [];
                if (count($search_customer)) {
                    foreach ($search_customer as $item) {
                        if (stripos($item['user_name'], $search) !== false) {
                            $matching_ids[] = $item['id'];
                        }
                    }
                }
                if (count($matching_ids)) {
                    $members = $members->whereIn('id', $matching_ids);
                } else {
                    $members = $members->where('email', 'like', '%' . $search . '%');
                }
            }
            $members = $members->paginate(5);
            return view('dashboard.customer-manager.member-card', ['members' => $members]);
        }

        $members = $members->paginate(5);
        if (count($members) > 0) {
            foreach ($members as $value) {
                $payment_amount = Payment::where('customer_id', $value->id)->where('subscription_id', $value->active_subscription)->whereNull('event_registartion_id')->orderBy('id', 'desc')->first();
                $value->amount = $payment_amount == null || $payment_amount->total_amount == null ? 0 : $payment_amount->total_amount;

                $total_amount += $value->amount;
            }
        }
        return view('dashboard.customer-manager.member-dashboard', ['members' => $members, 'years' => $years, 'total_amount' => $total_amount]);
    }
    public function editMember($id)
    {
        if (!Auth::user()->hasPermission('member_management-update')) {
            abort(403);
        }
        $member = Customer::with(['getActiveSubscriptionDetails'])->where('id', $id)->first();
        $country = Country::get();
        return view('dashboard.customer-manager.edit-member', ['country' => $country, 'member' => $member]);
    }
    public function updateMember(Request $request)
    {
        if (!Auth::user()->hasPermission('member_management-update')) {
            abort(403);
        }
        try {
            $check_customer = Customer::where('id', $request->id)->first();
            if ($check_customer == null) {
                return redirect()->back()->with('errorMessage', 'Member not found!');
            }

            if ($request->password != null && Hash::check($request->password, $check_customer->password)) {
                return redirect()->back()->with('errorMessage', 'You\'ve used this Password before. Try again with a different Password.');
            }
            if ($check_customer->email != $request->email) {
                $check_mail = Customer::where('email', $request->email)->get();
                if (count($check_mail) > 0) {
                    return redirect()->back()->with('errorMessage', 'Mail ID already exist!');
                }
            }
            $token = Str::uuid()->toString();
            if (request()->hasFile('profile_pic')) {
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
                $previous_pic = $check_customer->profile_pic;
            } else {
                $profile_pic = null;
            }
            $check_customer->first_name = $request->first_name;
            $check_customer->last_name = $request->last_name;
            $check_customer->user_name = $request->full_name;
            $check_customer->social_media_link = $request->social_media_link;
            $check_customer->nomination = $request->nomination;
            if ($check_customer->email != $request->email) {
                $check_customer->email = $request->email;
                $check_customer->is_verify_email = '0';
                $check_customer->email_token = $token;
            }
            $check_customer->country = $request->country;
            if ($profile_pic != null) {
                $check_customer->profile_pic = $profile_pic;
            }
            if ($request->password != null) {
                $check_customer->password = Hash::make($request->password);
            }
            $check_customer->save();
            if ($profile_pic != null && $check_customer->save()) {
                if (file_exists(public_path() . '/uploads/profile_pic/' . $previous_pic)) {
                    unlink(public_path() . '/uploads/profile_pic/' . $previous_pic);
                }
                $request->profile_pic->move(public_path() . '/uploads/profile_pic', $profile_pic);
            }

            if ($check_customer->email != $request->email) {
                $details = [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'mail' => $request->email,
                    'activate_link' =>  url('customer/account/confirm?token=' . $token),
                ];
                Mail::to($request->email)->send(new \App\Mail\CustomerRegistrationMail($details));
            }
            return redirect()->back()->with('doneMessage', 'Member updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
    public function exportMember(Request $request)
    {
        if (!Auth::user()->hasPermission('member_management-read')) {
            abort(403);
        }
        return Excel::download(new ExportMember($request->all()), 'members.xlsx');
    }
    public function viewMember(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('member_management-read')) {
            abort(403);
        }
        $nomination = null;
        $customer_nomination = null;
        $type = $request->type;

        if ($type == 'nomination' && $request->position_uuid != null) {
            $nomination = NominationPosition::with('getPosition')->where('uuid', $request->position_uuid)->first();
            if ($nomination != null && $request->member_id != null) {
                $customer_nomination = CustomerNomination::with('getMemberName')->where('nomination_uuid', $nomination->nomination_uuid)->where('nomination_position_uuid', $nomination->position_uuid)->where('member_id', $request->member_id)->first();
            }
        }

        if ($type == 'election') {
            $nomination = VotingPosition::where('uuid', $request->position_uuid)->with('getNominationPositionDetails')->first();
            if ($nomination != null) {
                $customer_nomination = CustomerVoting::where('voting_position_uuid', $nomination->uuid)->where('member_id', $request->member_id)->with('getVotedMemberDetails')->first();
            }
        }

        $member_details = Customer::with(['getActiveSubscriptionDetails', 'getSubscriptionHistory', 'getPaymentHistory'])->where('id', $id)->first();
        return view('dashboard.customer-manager.view-member', ['member_details' => $member_details, 'nomination' => $nomination, 'customer_nomination' => $customer_nomination, 'type' => $type]);
    }
    public function resendEmail(Request $request)
    {
        try {
            $token = Str::uuid()->toString();
            $check_customer = Customer::where('id', $request->customer_id)->first();
            if ($check_customer == null) {
                abort(404);
            }

            $check_customer->email_token = $token;
            $check_customer->save();

            $details = [
                'name' => $check_customer->user_name,
                'mail' => $check_customer->email,
                'activate_link' =>  url('customer/account/confirm?token=' . $check_customer->email_token),
            ];
            Mail::to($check_customer->email)->send(new \App\Mail\CustomerRegistrationMail($details));
            return redirect()->back()->with('doneMessage', 'Verification Mail Sent Successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
