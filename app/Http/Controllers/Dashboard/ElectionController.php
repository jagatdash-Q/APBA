<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ExportCustomerElection;
use App\Exports\ExportElectionPosition;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVoting;
use App\Models\MembershipPosition;
use App\Models\Nomination;
use App\Models\NominationAcceptList;
use App\Models\NominationPosition;
use App\Models\Voting;
use App\Models\VotingAcceptedList;
use App\Models\VotingContent;
use App\Models\VotingPosition;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ElectionController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        $voting_position = [];
        if ($request->has('election')) {
            $votings = Voting::with(['getVotingPositions', 'getNominationDetails'])->where('uuid', $request->election)->first();
            $voting_position = VotingPosition::with(['getNominationPositionDetails', 'getPositionDetails', 'getTotalVoting'])->where('voting_uuid', $request->election)->get();
        } else {

            $votings = Voting::with(['getVotingPositions', 'getNominationDetails'])->orderBy('id', 'desc')->first();
            // Get progress of voting poitions
            if ($votings != null) {
                $voting_position = VotingPosition::with(['getNominationPositionDetails', 'getPositionDetails', 'getTotalVoting'])->where('voting_uuid', $votings->uuid)->get();
            }
        }

        $all_votings = Voting::with(['getVotingPositions', 'getNominationDetails'])->orderBy('id', 'desc')->get();
        // get valid customers for cast vote
        $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', 'not like', '%Corporate%');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();


        // Get percentage
        $color_class = ['primary', 'success', 'danger', 'secondary', 'warning', 'info'];
        $vote_progress_data = [];
        foreach ($voting_position as $key => $val) {
            $total_given_voting = count($val->getTotalVoting);
            $total_vote = (($total_given_voting / $total_customer) * 100);

            $vote_progress_data[$key]['total_vote'] = number_format(floatval($total_vote), 2, '.', '');
            $vote_progress_data[$key]['total_customers'] = $total_customer;
            if ($val->getNominationPositionDetails != null) {
                if ($val->getNominationPositionDetails->getPosition != null) {
                    $vote_progress_data[$key]['position_name'] = $val->getNominationPositionDetails->getPosition->membership_position;
                }
            } else {
                $vote_progress_data[$key]['position_name'] = '';
            }
            $vote_progress_data[$key]['color'] =  $color_class[array_rand($color_class, 1)];
        }
        return view('dashboard.election.dashboard', ['votings' => $votings, 'vote_progress_data' => $vote_progress_data, 'all_votings' => $all_votings]);
    }

    public function electionDetails(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        if ($request->uuid == '') {
            return redirect()->route('admin.election.dashboard')->with('errorMessage', 'Election Position not found');
        } else {

            // Get Voting Details
            $voting_details = VotingPosition::where('uuid', $request->uuid)->with(['getNominationPositionDetails', 'getVotingDetails', 'getTotalVoting'])->first();
            if ($voting_details == null) {
                abort(404);
            }

            // Check Member has been elected or not
            $is_member_elected = VotingAcceptedList::with('getElectedMemberDetails')->where('voting_position_uuid', $request->uuid)->first();


            $position_details = CustomerVoting::where('voting_position_uuid', $request->uuid)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails'])->first();
            $customer_votings = CustomerVoting::where('voting_position_uuid', $request->uuid)->pluck('member_id')->unique();
            $details = [];
            $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
                $query->where('membership_name', 'not like', '%Corporate%');
            })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();
            if (count($customer_votings) > 0) {
                foreach ($customer_votings as $key => $val) {
                    $customer_election_details = CustomerVoting::with('getVotedMemberDetails')->where('voting_position_uuid', $request->uuid)->where('member_id', $val)->first();
                    $customer_election_details_count = CustomerVoting::with('getVotedMemberDetails')->where('voting_position_uuid', $request->uuid)->where('member_id', $val)->count();
                    if ($customer_election_details != null && $customer_election_details->getVotedMemberDetails != null) {
                        $total_vote_percentage = (($customer_election_details_count / $total_customer) * 100);
                        $details[$key]['customer_name'] = $customer_election_details->getVotedMemberDetails->user_name;
                        $details[$key]['customer_id'] = $customer_election_details->getVotedMemberDetails->id;
                        $details[$key]['customer_image'] = $customer_election_details->getVotedMemberDetails->profile_pic;
                        $details[$key]['social_media_link'] = $customer_election_details->getVotedMemberDetails->social_media_link;
                        $details[$key]['total_vote'] = $customer_election_details_count;
                        $details[$key]['total_vote_percentage'] = number_format(floatval($total_vote_percentage), 2, '.', '');
                        $details[$key]['voting_position_uuid'] = $customer_election_details->voting_position_uuid;
                    }
                }
            }
            return view('dashboard.election.election-details', ['details' => $details, 'position_details' => $position_details, 'total_customer' => $total_customer, 'voting_details' => $voting_details, 'is_member_elected' => $is_member_elected]);
        }
    }

    public function getChoosedMemberList($position_uuid, $member_id)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        $customer_list = CustomerVoting::where('voting_position_uuid', $position_uuid)->where('member_id', $member_id)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails', 'getCustomerDetails'])->get();
        $election_details = CustomerVoting::where('voting_position_uuid', $position_uuid)->where('member_id', $member_id)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails', 'getCustomerDetails'])->first();
        $customer_details = Customer::whereId($member_id)->first();
        if (count($customer_list) > 0) {
            return view('dashboard.election.election-customer-list', ['customer_list' => $customer_list, 'customer_details' => $customer_details, 'position_uuid' => $position_uuid, 'member_id' => $member_id, 'election_details' => $election_details]);
        } else {
            abort(404);
        }
    }

    public function electionContentManage(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        $content = VotingContent::first();
        return view('dashboard.election.manage-content', ['content' => $content]);
    }

    public function electionCreateContent(Request $request)
    {

        $content = VotingContent::first();
        if ($content == null) {
            if (!Auth::user()->hasPermission('election_management-create')) {
                abort(403);
            }
            try {
                VotingContent::create([
                    'heading' => $request->heading,
                    'description' => $request->description,
                    'description_data' => $request->description_data,
                    'content_description' => $request->content_description,
                    'content_description_data' => $request->content_description_data,
                    'created_by' => Auth::id()
                ]);
                return redirect()->back()->with('doneMessage', 'Voting content created successfully');
            } catch (Exception $e) {
                Log::info('Error in creation of election content :-' . $e->getMessage());
                return redirect()->back()->with('errorMessage', 'Something went wrong please try after sometime');
            }
        } else {
            if (!Auth::user()->hasPermission('election_management-update')) {
                abort(403);
            }
            try {

                VotingContent::whereId($content->id)->update([
                    'heading' => $request->heading,
                    'description' => $request->description,
                    'description_data' => $request->description_data,
                    'content_description' => $request->content_description,
                    'content_description_data' => $request->content_description_data,
                    'updated_by' => Auth::id()
                ]);
                return redirect()->back()->with('doneMessage', 'Voting content updated successfully');
            } catch (Exception $e) {
                Log::info('Error in creation of election content :-' . $e->getMessage());
                return redirect()->back()->with('errorMessage', 'Something went wrong please try after sometime');
            }
        }
    }

    public function createElection(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-create')) {
            abort(403);
        }
        // Get unique nomination of accepted list
        $nominations_accepted = NominationAcceptList::groupBy('nomination_uuid')->pluck('nomination_uuid')->toArray();
        // Get Nomination details
        $nominations = Nomination::whereIn('uuid', $nominations_accepted)->get();
        return view('dashboard.election.create', ['nominations' => $nominations]);
    }

    public function getAvailableElectionPosition(Request $request)
    {
        try {
            if ($request->nomination_uuid != '') {
                $is_voting_created = Voting::where('nomination_uuid', $request->nomination_uuid)->pluck('uuid')->toArray();
                if (count($is_voting_created) > 0) {
                    $positions = VotingPosition::whereIn('voting_uuid', $is_voting_created)->pluck('nomination_position_uuid')->toArray();
                    $finalpositions = NominationPosition::whereNotIn('uuid', $positions)->where('nomination_uuid', $request->nomination_uuid)->with('getPosition')->get();
                } else {
                    $finalpositions = NominationPosition::where('nomination_uuid', $request->nomination_uuid)->with('getPosition')->get();
                }
                return ['status' => 'success', 'result' => $finalpositions];
            } else {
                return ['status' => 'error', 'message' => 'Invalid details'];
            }
        } catch (Exception $e) {
            Log::info('Error in getting available position for election:' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Invalid details'];
        }
    }

    public function storeElection(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-create')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'nomination' => 'required',
            'nomination_position' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $status = '1';
            $is_voting_create = Voting::create([
                'uuid' => Str::uuid()->toString(),
                'nomination_uuid' => $request->nomination,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $status,
                'created_by' => Auth::id(),
            ]);
            if ($is_voting_create) {
                foreach ($request->nomination_position as $val) {
                    VotingPosition::create([
                        'uuid' => Str::uuid()->toString(),
                        'voting_uuid' => $is_voting_create->uuid,
                        'nomination_position_uuid' => $val
                    ]);
                }
            }
            return redirect()->back()->with('doneMessage', 'All voting positions has been created');
        } catch (Exception $e) {
            Log::info('Error in creating voting' . $e->getMessage());
            return redirect()->back()->with('errorMessage', 'Something went wrong please try after sometime');
        }
    }
    public function electionPositionExport(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        return Excel::download(new ExportElectionPosition($request->voting_position_uuid), 'election-postion.xlsx');
    }
    public function customerElectionExport(Request $request)
    {
        if (!Auth::user()->hasPermission('election_management-read')) {
            abort(403);
        }
        return Excel::download(new ExportCustomerElection($request->voting_position_uuid, $request->member_id), 'customer-election.xlsx');
    }

    public function electMemberForPosition(Request $request)
    {
        try {
            $is_position_elected = VotingAcceptedList::where('voting_uuid', $request->voting_uuid)->where('voting_position_uuid', $request->voting_position_uuid)->first();
            if ($is_position_elected == null) {
                VotingAcceptedList::create([
                    'uuid' => Str::uuid()->toString(),
                    'voting_uuid' => $request->voting_uuid,
                    'voting_position_uuid' => $request->voting_position_uuid,
                    'member_id' => $request->member_id,
                    'approved_by' => Auth::id()
                ]);
                return ['status' => 'success', 'message' => 'Member has been elected for the position'];
            } else {
                return ['status' => 'error', 'message' => 'A Member has been already elected for the position'];
            }
        } catch (Exception $e) {
            Log::info('Error in elect member for position:' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Something went wrong please try after sometime'];
        }
    }
}
