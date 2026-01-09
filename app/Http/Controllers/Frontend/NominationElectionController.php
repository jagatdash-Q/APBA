<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerNomination;
use App\Models\MembershipType;
use App\Models\Nomination;
use App\Models\NominationContent;
use App\Models\NominationRejectList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerVoting;
use App\Models\NominationAcceptList;
use App\Models\Voting;
use App\Models\VotingContent;
use Exception;
use Illuminate\Support\Facades\Log;

class NominationElectionController extends Controller
{
    public function nomination(Request $request)
    {

        if(Auth::guard('customer')->user()->current_subscription_status=='e'){
            return redirect()->route('customer.home')->with('errorMessage',"Your subscription has been expired. You can't take part in nomination.");
        }

        $nomination_details = [];
        $temp_type = null;
        $nomination = Nomination::with('getNominationPosition')->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->first();
        if ($nomination != null && isset($nomination->getNominationPosition)) {
            if (count($nomination->getNominationPosition) > 0) {
                $count = 0;
                foreach ($nomination->getNominationPosition as $position) {
                    if (isset($position->getPosition) && isset($position->getPosition->getMembershipType)) {
                        $membership_type_uuid = $position->getPosition->getMembershipType->uuid;
                        if ($temp_type == null || $temp_type != $membership_type_uuid) {
                            $count = 0;
                            $temp_type = $membership_type_uuid;
                            $nomination_details[$membership_type_uuid][] = $position;
                        } elseif ($temp_type == $membership_type_uuid) {
                            $count++;
                            $nomination_details[$membership_type_uuid][] = $position;
                        }
                    }
                }
            }
        }

        if (count($nomination_details)) {
            foreach ($nomination_details as $position) {
                if (count($position)) {
                    foreach ($position as $value) {
                        $get_nominate = CustomerNomination::with('getMemberName')->where('customer_id', Auth::guard('customer')->user()->id)->where('nomination_uuid', $value->nomination_uuid)->where('nomination_position_uuid', $value->position_uuid)->first();
                        $value->nominated_member = $get_nominate == null ? null : $get_nominate->getMemberName->user_name;
                    }
                }
            }
        }
        $membership_type = MembershipType::pluck('membership_type', 'uuid')->toArray();

        $all_customer_for_nomintion = Customer::query();
        $all_customer_for_nomintion = $all_customer_for_nomintion->whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', '!=', 'Association Membership');
            $query->where('membership_name', '!=', 'Corporate Membership');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes');
        

        if ($request->ajax()) {
            if ($request->nomination_uuid != null && $request->position_uuid != null) {
                $get_reject_list = NominationRejectList::where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->pluck('member_id')->toArray();
                $all_customer_for_nomintion = $all_customer_for_nomintion->whereNotIn('id', $get_reject_list);
            }
            // Get all customers first
            $data = $all_customer_for_nomintion->get();
            if ($request->order === null || strtolower($request->order) === 'asc') {
                // Default to ascending sort
                $data = $data->sortBy(function ($customer) {
                    return strtolower($customer->user_name);
                });
            } elseif (strtolower($request->order) === 'desc') {
                // Sort descending
                $data = $data->sortBy(function ($customer) {
                    return strtolower($customer->user_name);
                })->reverse();
            }
            if($request->search != null){
                $data = $data->filter(function ($customer) use ($request) {
                    return stripos($customer->user_name, $request->search) !== false;
                });
            }
            $ids = $data->pluck('id')->toArray();
            $all_customer_for_nomintion = Customer::whereIn('id', $ids)->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')->paginate(10);
            return view('frontend.customer.nomination.nomination_members', ['all_customer_for_nomintion' => $all_customer_for_nomintion]);
        }

        $all_customer_for_nomintion = [];
        $nomination_content = NominationContent::first();

        return view('frontend.customer.nomination.nomination', ['nomination_details' => $nomination_details, 'all_customer_for_nomintion' => $all_customer_for_nomintion, 'membership_type' => $membership_type, 'nomination_content' => $nomination_content]);
    }

    // public function nomination(Request $request)
    // {
    //     $nomination_details = [];
    //     $temp_type = null;
    //     $nomination = Nomination::with('getNominationPosition')->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->first();
    //     // echo "<pre>";
    //     if ($nomination != null) {
    //         if (isset($nomination->getNominationPosition)) {
    //             // dump($nomination->getNominationPosition);
    //             if (count($nomination->getNominationPosition)) {
    //                 $count = 0;
    //                 foreach ($nomination->getNominationPosition as $position) {
    //                     if (isset($position->getPosition)) {
    //                         if (isset($position->getPosition->getMembershipType)) {
    //                             // $membership_type_uuid = $position->getPosition->getMembershipType->uuid;
    //                             $membership_type_uuid = $position->getPosition->getMembershipType->uuid;
    //                             // dump($membership_type_uuid);
    //                             // dump($position);
    //                             if ($temp_type == null || $temp_type != $membership_type_uuid) {
    //                                 $count = 0;
    //                                 $temp_type = $membership_type_uuid;
    //                                 // dump("if");
    //                                 // dump($count);
    //                                 $nomination_details[$membership_type_uuid][] = $position;
    //                             } elseif ($temp_type == $membership_type_uuid) {
    //                                 $count++;
    //                                 $nomination_details[$membership_type_uuid][] = $position;
    //                                 // dump("else");
    //                                 // dump($count);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // dd($nomination_details);


    //     if (count($nomination_details)) {
    //         foreach ($nomination_details as $position) {
    //             if (count($position)) {
    //                 foreach ($position as $value) {
    //                     $get_nominate = CustomerNomination::with('getMemberName')->where('customer_id', Auth::guard('customer')->user()->id)->where('nomination_uuid', $value->nomination_uuid)->where('nomination_position_uuid', $value->position_uuid)->first();
    //                     if ($get_nominate == null)
    //                         $value->nominated_member = null;
    //                     else
    //                         $value->nominated_member = $get_nominate->getMemberName->user_name;
    //                 }
    //             }
    //         }
    //     }
    //     $membership_type = MembershipType::pluck('membership_type', 'uuid')->toArray();

    //     $all_customer_for_nomintion = Customer::query();
    //     $all_customer_for_nomintion = $all_customer_for_nomintion->whereHas('getActiveSubscriptionDetails', function ($query) {
    //         $query->where('membership_name', '!=', 'Association Membership');
    //         $query->where('membership_name', '!=', 'Corporate Membership');
    //     })->where('current_subscription_status', 'a')->where('nomination', 'yes');

    //     if ($request->ajax()) {
    //         if ($request->search != null)
    //             $all_customer_for_nomintion = $all_customer_for_nomintion->where('user_name', 'like', '%' . $request->search . '%');

    //         if ($request->order != null)
    //             $all_customer_for_nomintion = $all_customer_for_nomintion->orderBy('user_name', $request->order);

    //         if ($request->nomination_uuid != null && $request->position_uuid != null) {

    //             $get_reject_list = NominationRejectList::where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->pluck('member_id')->toArray();

    //             $all_customer_for_nomintion = $all_customer_for_nomintion->whereNotIn('id', $get_reject_list);
    //         }


    //         $all_customer_for_nomintion = $all_customer_for_nomintion->paginate(10);
    //         return view('frontend.customer.nomination.nomination_members', compact('all_customer_for_nomintion'));
    //     }

    //     $all_customer_for_nomintion = [];
    //     $nomination_content = NominationContent::first();

    //     return view('frontend.customer.nomination.nomination', compact('nomination_details', 'all_customer_for_nomintion', 'membership_type', 'nomination_content'));
    // }

    public function submit_nomination(Request $request)
    {
        if ($request->ajax()) {
            try {
                if(Auth::guard('customer')->user()->current_subscription_status=='e'){
                    return ['error', "Your subscription has been expired. You can't take part in nomination."];
                }
                $check_nomination = CustomerNomination::where('customer_id', Auth::guard('customer')->user()->id)->where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->count();

                if ($check_nomination != 0) {
                    return ['warning', "You have nominate only one persion for only one position."];
                }

                $nominate_by_customer = new CustomerNomination();
                $nominate_by_customer->customer_id = Auth::guard('customer')->user()->id;
                $nominate_by_customer->member_id = $request->member_id;
                $nominate_by_customer->nomination_uuid = $request->nomination_uuid;
                $nominate_by_customer->nomination_position_uuid = $request->position_uuid;
                $nominate_by_customer->save();
                return ['success', "Nominated successfully."];
            } catch (\Throwable $th) {
                return ['error', "Something went wrong! Please try again later."];
            }
        }
        return null;
    }

    // Election module

    public function electionDetails(Request $request)
    {
        if(Auth::guard('customer')->user()->current_subscription_status=='e'){
            return redirect()->route('customer.home')->with('errorMessage',"Your subscription has been expired. You can't take part in election.");
        }
        // $elections = Voting::with(['getVotingPositions.getVotedMemberDetails' => function ($query) {
        //     $query->where('customer_id', Auth::guard('customer')->id());
        // }, 'getNominationDetails'])->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->get();
        $election_content = VotingContent::first();
        $customer_for_voting = [];
        $elections = [];
        $temp_type = null;
        $election_details = Voting::with(['getVotingPositions.getVotedMemberDetails' => function ($query) {
            $query->where('customer_id', Auth::guard('customer')->id());
        }, 'getNominationDetails'])->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->where('status', '1')->first();

        if ($election_details != null && isset($election_details->getVotingPositions)) {
            if (count($election_details->getVotingPositions) > 0) {
                $count = 0;
                foreach ($election_details->getVotingPositions as $position) {
                    if (isset($position->getNominationPositionDetails) && isset($position->getNominationPositionDetails->getPosition)) {
                        if (isset($position->getNominationPositionDetails->getPosition->getMembershipType)) {
                            $membership_type_uuid = $position->getNominationPositionDetails->getPosition->getMembershipType->uuid;
                            if ($temp_type == null || $temp_type != $membership_type_uuid) {
                                $count = 0;
                                $temp_type = $membership_type_uuid;
                                $elections[$membership_type_uuid][] = $position;
                            } elseif ($temp_type == $membership_type_uuid) {
                                $count++;
                                $elections[$membership_type_uuid][] = $position;
                            }
                        }
                    }
                }
            }
        }
        $membership_type = MembershipType::pluck('membership_type', 'uuid')->toArray();

        return view('frontend.customer.election.voting', ['elections' => $elections, 'customer_for_voting' => $customer_for_voting, 'election_content' => $election_content, 'membership_type' => $membership_type, 'election_details' => $election_details]);
    }


    public function getCustomersForVoting(Request $request)
    {
        $customer_for_voting = Customer::query();
        // Get the customer ids
        $accepted_list = NominationAcceptList::where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->get('member_id');
        $customer_for_voting = $customer_for_voting->whereIn('id', $accepted_list);

        if ($request->search != null) {
            $customer_for_voting = $customer_for_voting->where('user_name', 'like', '%' . $request->search . '%');
        }
        if ($request->order != null) {
            $customer_for_voting = $customer_for_voting->orderBy('user_name', $request->order);
        }
        $customer_for_voting = $customer_for_voting->paginate(3);
        return view('frontend.customer.election.election_members', ['customer_for_voting' => $customer_for_voting]);
    }

    public function electVote(Request $request)
    {
        try{
            if(Auth::guard('customer')->user()->current_subscription_status=='e'){
                return ['status' => 'error', 'message' => "Your subscription has been expired. You can't take part in election."];
            }
            $is_customer_voted = CustomerVoting::where('customer_id', Auth::guard('customer')->user()->id)->where('nomination_uuid', $request->nomination_uuid)->where('voting_position_uuid', $request->voting_position_uuid)->where('voting_uuid', $request->voting_uuid)->first();
            if ($is_customer_voted == null) {
                CustomerVoting::create([
                    'customer_id' => Auth::guard('customer')->user()->id,
                    'nomination_uuid' => $request->nomination_uuid,
                    'voting_position_uuid' => $request->voting_position_uuid,
                    'voting_uuid' => $request->voting_uuid,
                    'member_id' => $request->member_id,
                ]);
                return ['status' => 'success', 'message' => 'You have successfully elected for this position'];
            } else {
                return ['status' => 'error', 'message' => 'Sorry you have already elected for the position'];
            }
        }catch(Exception $e){
            Log::info('Error in customer elect vote'.$e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong please try after sometime'];
        }
        
    }
}
