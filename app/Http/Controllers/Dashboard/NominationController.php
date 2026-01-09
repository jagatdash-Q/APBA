<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ExportCustomerNomination;
use App\Exports\ExportNominationPosition;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerNomination;
use App\Models\MembershipPosition;
use App\Models\MembershipType;
use App\Models\Nomination;
use App\Models\NominationAcceptList;
use App\Models\NominationContent;
use App\Models\NominationPosition;
use App\Models\NominationRejectList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class NominationController extends Controller
{
    public function membershipType()
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $memberhip_type = MembershipType::get();
        return view('dashboard.nomination.membership_type.index', compact('memberhip_type'));
    }
    public function createUpdateMembershipType(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-create'))
            abort(403);
        try {
            $memberhip_type = MembershipType::firstOrNew(['uuid' => $request->uuid]);
            $memberhip_type->membership_type = $request->membership_type;
            $memberhip_type->status = '1';
            $memberhip_type->save();
            if ($request->type == '0')
                return redirect()->back()->with('doneMessage', 'Membership type created successfully.');
            else
                return redirect()->back()->with('doneMessage', 'Membership type updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function deleteMembershipType(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-delete'))
            abort(403);
        try {
            $memberhip_type = MembershipType::where('uuid', $request->uuid)->first();
            if ($memberhip_type == null)
                return redirect()->back()->with('errorMessage', 'Membership type not found.');

            MembershipPosition::where('membership_type_uuid', $memberhip_type->uuid)->delete();
            $memberhip_type->delete();
            return redirect()->back()->with('doneMessage', 'Membership type deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function editMembershipType($uuid)
    {
        if (!Auth::user()->hasPermission('nomination_management-update'))
            abort(403);
        $memberhip_type = MembershipType::where('uuid', $uuid)->first();
        if ($memberhip_type == null)
            return redirect()->back()->with('errorMessage', 'Membership type not found.');
        return view('dashboard.nomination.membership_type.edit', compact('memberhip_type'));
    }

    public function membershipPosition()
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $memberhip_type = MembershipType::get();
        $memberhip_position = MembershipPosition::with('getMembershipType')->get();
        return view('dashboard.nomination.membership_position.index', compact('memberhip_type', 'memberhip_position'));
    }
    public function createMembershipPosition(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-create'))
            abort(403);
        try {
            $memberhip_position = MembershipPosition::firstOrNew(['uuid' => $request->uuid]);
            $memberhip_position->membership_type_uuid = $request->membership_type_uuid;
            $memberhip_position->membership_position = $request->membership_position;
            $memberhip_position->status = '1';
            $memberhip_position->save();
            if ($request->type == '0')
                return redirect()->back()->with('doneMessage', 'Membership position created successfully.');
            else
                return redirect()->back()->with('doneMessage', 'Membership position updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function deleteMembershipPosition(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-delete'))
            abort(403);
        try {
            MembershipPosition::where('uuid', $request->uuid)->delete();
            return redirect()->back()->with('doneMessage', 'Membership position deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function editMembershipPosition($uuid)
    {
        if (!Auth::user()->hasPermission('nomination_management-update'))
            abort(403);
        $memberhip_type = MembershipType::get();
        $memberhip_position = MembershipPosition::where('uuid', $uuid)->first();
        if ($memberhip_position == null)
            return redirect()->back()->with('errorMessage', 'Membership position not found.');
        return view('dashboard.nomination.membership_position.edit', compact('memberhip_position', 'memberhip_type'));
    }
    public function createNomination()
    {
        if (!Auth::user()->hasPermission('nomination_management-create'))
            abort(403);
        $memberhip_position = MembershipPosition::where('status', '1')->get();
        return view('dashboard.nomination.create', compact('memberhip_position'));
    }
    public function storeNomination(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-create'))
            abort(403);
        try {
            $nomination = new Nomination();
            $nomination->uuid = Str::uuid()->toString();
            $nomination->name = $request->nomination_name;
            $nomination->start_date = $request->start_date;
            $nomination->end_date = $request->end_date;
            $nomination->status = '1';
            $nomination->created_by = Auth::id();
            $nomination->save();
            if ($nomination->save()) {
                if (count($request->membership_position_uuid)) {
                    foreach ($request->membership_position_uuid as $position_uuid) {
                        $nomination_position = new NominationPosition();
                        $nomination_position->uuid = Str::uuid()->toString();
                        $nomination_position->nomination_uuid = $nomination->uuid;
                        $nomination_position->position_uuid = $position_uuid;
                        $nomination_position->save();
                    }
                }
                return redirect()->route('admin.nomination.dashboard')->with('doneMessage', 'Nomination created successfully.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', $th->getMessage());
        }
    }
    public function dashboard(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $all_nomination_list = Nomination::get();
        $nomination = Nomination::query();
        if (!$request->has('restore')) {
            if ($request->has('filter')) {
                if ($request->nomination_uuid != null)
                    $nomination = $nomination->where('uuid', $request->nomination_uuid);
            }
        }
        $nomination = $nomination->with('getNominationPosition')->orderBy('id', 'desc')->first();

        $nomination_progress_chart = [];
        $color_class = ['primary', 'success', 'danger', 'secondary', 'warning', 'info'];
        $color_for_chart = [];
        if ($nomination != null) {
            if (isset($nomination->getNominationPosition)) {
                if (count($nomination->getNominationPosition)) {
                    $loopCount = count($nomination->getNominationPosition);
                    for ($i = 0; $i < $loopCount; $i++) {
                        $currentItemIndex = $i % count($color_class);
                        $color_for_chart[] = $color_class[$currentItemIndex];
                        if ($currentItemIndex === count($color_class) - 1)
                            $loopCount += count($color_class) - $currentItemIndex - 1;
                    }
                    foreach ($nomination->getNominationPosition as $key => $value) {
                        $get_count = CustomerNomination::where('nomination_uuid', $value->nomination_uuid)->where('nomination_position_uuid', $value->position_uuid)->count();
                        $nomination_progress_chart[] = [
                            'position' => isset($value->getPosition) ? $value->getPosition->membership_position : 'Not Available',
                            'total_nomination' => $get_count,
                            'color_class' => $color_for_chart[$key]
                        ];
                    }
                }
            }
        }

        $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', '!=', 'Corporate Membership');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();

        return view('dashboard.nomination.dashboard', compact('nomination', 'all_nomination_list', 'nomination_progress_chart', 'total_customer'));
    }
    public function manageNominationContent()
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $content = NominationContent::first();
        return view('dashboard.nomination.manage-content', compact('content'));
    }
    public function nominationCreateContent(Request $request)
    {

        $content = NominationContent::first();
        if ($content == null) {
            if (!Auth::user()->hasPermission('nomination_management-create'))
                abort(403);
            NominationContent::create([
                'heading' => $request->heading,
                'description' => $request->description,
                'description_data' => $request->description_data,
                'content_description' => $request->content_description,
                'content_description_data' => $request->content_description_data,
                'created_by' => Auth::id()
            ]);
            return redirect()->back()->with('doneMessage', 'Nomination content created successfully');
        } else {
            if (!Auth::user()->hasPermission('nomination_management-update'))
                abort(403);
            NominationContent::whereId($content->id)->update([
                'heading' => $request->heading,
                'description' => $request->description,
                'description_data' => $request->description_data,
                'content_description' => $request->content_description,
                'content_description_data' => $request->content_description_data,
                'updated_by' => Auth::id()
            ]);
            return redirect()->back()->with('doneMessage', 'Nomination content updated successfully');
        }
    }
    public function nominationPositionDetails($uuid)
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $member_nomination = [];
        $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', '!=', 'Corporate Membership');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details == null)
            abort(404);

        // $nomination_list = CustomerNomination::with('getMemberName')->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->get();
        $nomination_member_ids = CustomerNomination::where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->pluck('member_id')->unique();
        if (count($nomination_member_ids)) {

            foreach ($nomination_member_ids as $member_id) {
                $member = CustomerNomination::with('getMemberName')->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $member_id)->first();
                if ($member != null) {
                    $total_vote = CustomerNomination::where('member_id', $member->member_id)->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->count();
                    $total_percentage = ($total_vote * 100) / $total_customer;

                    $get_member_status = NominationRejectList::where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $member->member_id)->first();

                    $check_accept = NominationAcceptList::where('member_id', $member->member_id)->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->first();

                    if ($get_member_status != null && $check_accept == null)
                        $status = 1;
                    elseif ($get_member_status == null && $check_accept != null)
                        $status = 2;
                    else
                        $status = 0;

                    $member_nomination[] = [
                        'member_id' => $member->getMemberName->id,
                        'name' => $member->getMemberName->user_name,
                        'profile_pic' => $member->getMemberName->profile_pic,
                        'total_vote' => $total_vote,
                        'total_percentage' => number_format(floatval($total_percentage), 2, '.', ''),
                        'status' => $status
                    ];
                }
            }
        }
        return view('dashboard.nomination.position-details', compact('total_customer', 'check_details', 'member_nomination'));
    }
    public function nominationPositionReject(Request $request)
    {
        if ($request->ajax()) {
            try {
                $check_reject = NominationRejectList::where('member_id', $request->member_id)->where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->count();

                if ($check_reject != 0)
                    return ['warning', "You have already reject this member."];

                $reject = new NominationRejectList();
                $reject->nomination_uuid = $request->nomination_uuid;
                $reject->nomination_position_uuid = $request->position_uuid;
                $reject->member_id = $request->member_id;
                $reject->rejected_by = Auth::id();
                $reject->save();
                return ['success', "Member Rejected."];
            } catch (\Throwable $th) {
                return ['error', $th->getMessage()];
            }
        }
    }
    public function nominationPositionAccept(Request $request)
    {
        if ($request->ajax()) {
            try {

                $get_member_status = NominationRejectList::where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->where('member_id', $request->member_id)->count();
                if ($get_member_status != 0)
                    return ['warning', "You have already reject this member."];

                $check_accept = NominationAcceptList::where('member_id', $request->member_id)->where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->count();

                if ($check_accept != 0)
                    return ['warning', "You have already approve this member."];
                $total_vote = CustomerNomination::where('member_id', $request->member_id)->where('nomination_uuid', $request->nomination_uuid)->where('nomination_position_uuid', $request->position_uuid)->count();
                if ($total_vote < 2)
                    return ['warning', "Minimum 2 members are required to nominate a member for selection."];

                $reject = new NominationAcceptList();
                $reject->nomination_uuid = $request->nomination_uuid;
                $reject->nomination_position_uuid = $request->position_uuid;
                $reject->member_id = $request->member_id;
                $reject->accepted_by = Auth::id();
                $reject->save();
                return ['success', "Member Approved."];
            } catch (\Throwable $th) {
                return ['error', $th->getMessage()];
            }
        }
    }

    public function customerNominationList($uuid, $member_id)
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details == null)
            abort(404);

        $customer_nomination = CustomerNomination::with(['getMemberName', 'getCustomer'])->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $member_id)->get();

        return view('dashboard.nomination.nomination_customer', compact('check_details', 'customer_nomination'));
    }
    public function nominationPositionExport(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        return Excel::download(new ExportNominationPosition($request->nomination_position_uuid), 'nomination-postion.xlsx');
    }
    public function customerNominationExport(Request $request)
    {
        if (!Auth::user()->hasPermission('nomination_management-read'))
            abort(403);
        return Excel::download(new ExportCustomerNomination($request->nomination_position_uuid, $request->member_id), 'customer-nomination-details.xlsx');
    }
}
