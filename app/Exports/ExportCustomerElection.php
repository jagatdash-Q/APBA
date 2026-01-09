<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\CustomerVoting;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportCustomerElection implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $uuid;
    public $member_id;
    public function __construct($uuid, $member_id)
    {
        $this->uuid = $uuid;
        $this->member_id = $member_id;
    }
    public function collection()
    {
        $temp_data = [];
        $uuid = $this->uuid;
        $member_id = $this->member_id;

        $customer_list = CustomerVoting::where('voting_position_uuid', $uuid)->where('member_id', $member_id)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails', 'getCustomerDetails'])->get();

        if (count($customer_list) > 0) {

            foreach ($customer_list as $member) {


                if (isset($member->getCustomerDetails)) {

                    if ($member->getCustomerDetails->current_subscription_status == 'a') {
                        $status = "Active";
                    } elseif ($member->getCustomerDetails->current_subscription_status == 'p') {
                        $status = "Pending";
                    } elseif ($member->getCustomerDetails->current_subscription_status == 'e') {
                        $status = "Expire";
                    } else {
                        $status = "";
                    }

                    if (isset($member->getCustomerDetails->getActiveSubscriptionDetails)) {
                        $membership_name = $member->getCustomerDetails->getActiveSubscriptionDetails->membership_name == null ? null : $member->getCustomerDetails->getActiveSubscriptionDetails->membership_name;
                    } else {
                        $membership_name = null;
                    }


                    $temp_data[] = [$member->getCustomerDetails->first_name . " " . $member->getCustomerDetails->last_name, $member->getCustomerDetails->email, $member->getCustomerDetails->is_verify_email == '0' ? 'No' : 'Yes', $member->getCustomerDetails->nomination, $membership_name, $status, Carbon::parse($member->getCustomerDetails->active_subscription_expired_on)->format('d F Y')];
                }
            }
        }




        return collect($temp_data);
    }
    public function headings(): array
    {
        $uuid = $this->uuid;
        $member_id = $this->member_id;
        $election_details = CustomerVoting::where('voting_position_uuid', $uuid)->where('member_id', $member_id)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails', 'getCustomerDetails'])->first();
        $customer_details = Customer::whereId($member_id)->first();
        if ($election_details != null) {
            $title = "Election Start & End Date: ";
            if (isset($election_details->getVotingDetails)) {
                $title .= Carbon::parse($election_details->getVotingDetails->start_date)->format('d F Y');
            }
            $title .= " to ";
            if (isset($election_details->getVotingDetails)) {
                $title .= Carbon::parse($election_details->getVotingDetails->end_date)->format('d F Y');
            }
            $title .= "\n Nomination Name: ";
            if (isset($election_details->getNominationDetails)) {
                $title .= $election_details->getNominationDetails->name;
            }
            $title .= "\n Membership Type: ";
            if (isset($election_details->getVotingPositionDetails) && isset($election_details->getVotingPositionDetails->getNominationPositionDetails)) {
                if (isset($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition) && isset($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType)) {
                    $title .= $election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType->membership_type;
                }
            }
            $title .= "\n Position: ";
            if ($election_details->getVotingPositionDetails != null && $election_details->getVotingPositionDetails->getNominationPositionDetails != null) {
                if ($election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition != null) {
                    $title .= $election_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->membership_position;
                }
            }

            $title .= "\n Member Name: ";
            if ($customer_details != null) {
                $title .= $customer_details->user_name;
            }
        } else {
            $title = ' ';
        }

        return [
            [$title, ' ', ' ', ' ', ' ', ' ', ' '],
            ['Member Name', 'Email', 'Email Verification Status', 'Nomination', 'Subscription Type', 'Subscription Status', 'Subscription Expire On'],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:G2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells('A1:G1');
            },
        ];
    }
}
