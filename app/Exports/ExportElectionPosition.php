<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\CustomerVoting;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportElectionPosition implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $uuid;
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }
    public function collection()
    {
        $temp_data = [];
        $uuid = $this->uuid;
        $customer_votings = CustomerVoting::where('voting_position_uuid', $uuid)->pluck('member_id')->unique();
        $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', 'not like', '%Corporate%');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();
        if (count($customer_votings) > 0) {
            foreach ($customer_votings as $val) {
                $customer_election_details = CustomerVoting::with('getVotedMemberDetails')->where('voting_position_uuid', $uuid)->where('member_id', $val)->first();
                $customer_election_details_count = CustomerVoting::with('getVotedMemberDetails')->where('voting_position_uuid', $uuid)->where('member_id', $val)->count();
                if ($customer_election_details != null && $customer_election_details->getVotedMemberDetails != null) {
                    $total_vote_percentage = (($customer_election_details_count / $total_customer) * 100);
                    $temp_data[] = [$customer_election_details->getVotedMemberDetails->user_name, $customer_election_details_count, number_format(floatval($total_vote_percentage), 2, '.', '')];
                }
            }
        }
        return collect($temp_data);
    }
    public function headings(): array
    {
        $uuid = $this->uuid;
        $position_details = CustomerVoting::where('voting_position_uuid', $uuid)->with(['getVotingDetails', 'getVotingPositionDetails', 'getNominationDetails'])->first();
        if ($position_details != null) {
            $title = "Election Start & End Date: ";
            if (isset($position_details->getVotingDetails)) {
                $title .= Carbon::parse($position_details->getVotingDetails->start_date)->format('d F Y');
            }
            $title .= " to ";
            if (isset($position_details->getVotingDetails)) {
                $title .= Carbon::parse($position_details->getVotingDetails->end_date)->format('d F Y');
            }
            $title .= "\n Nomination Name: ";
            if (isset($position_details->getNominationDetails)) {
                $title .= $position_details->getNominationDetails->name;
            }
            $title .= "\n Membership Type: ";
            if (isset($position_details->getVotingPositionDetails) && isset($position_details->getVotingPositionDetails->getNominationPositionDetails)) {
                if (isset($position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition) && isset($position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType)) {
                    $title .= $position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType->membership_type;
                }
            }
            $title .= "\n Position: ";
            if ($position_details->getVotingPositionDetails != null && $position_details->getVotingPositionDetails->getNominationPositionDetails != null) {
                if ($position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition != null) {
                    $title .= $position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->membership_position;
                }
            }
        } else {
            $title = ' ';
        }

        return [
            [$title, ' ', ' '],
            ['Member Name', 'Total Vote', 'Total Vote in %'],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:C1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:C2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells('A1:C1');
            },
        ];
    }
}
