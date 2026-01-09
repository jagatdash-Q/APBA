<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\CustomerNomination;
use App\Models\NominationAcceptList;
use App\Models\NominationPosition;
use App\Models\NominationRejectList;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportNominationPosition implements FromCollection, WithHeadings, WithEvents
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
        $total_customer = Customer::whereHas('getActiveSubscriptionDetails', function ($query) {
            $query->where('membership_name', '!=', 'Corporate Membership');
        })->where('current_subscription_status', 'a')->where('nomination', 'yes')->count();
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details != null) {
            $nomination_list = CustomerNomination::with('getMemberName')->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->get();
            if (count($nomination_list) > 0) {

                foreach ($nomination_list as $value) {
                    $total_vote = CustomerNomination::where('member_id', $value->member_id)->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->count();
                    $total_percentage = ($total_vote * 100) / $total_customer;

                    $get_member_status = NominationRejectList::where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $value->member_id)->first();

                    $check_accept = NominationAcceptList::where('member_id', $value->member_id)->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->first();

                    if ($get_member_status != null && $check_accept == null) {
                        $status = 'In Active';
                    } elseif ($get_member_status == null && $check_accept != null) {
                        $status = 'Move to Election';
                    } else {
                        $status = 'Active';
                    }


                    if (count($temp_data) === 0) {
                        $temp_data[] = [
                            $value->getMemberName->id, $value->getMemberName->user_name, $total_vote, number_format(floatval($total_percentage), 2, '.', ''), $status
                        ];
                    } else {
                        foreach ($temp_data as $key => $check) {
                            if ($check[$key] != $value->member_id) {
                                $temp_data[] = [
                                    $value->getMemberName->id, $value->getMemberName->user_name, $total_vote, number_format(floatval($total_percentage), 2, '.', ''), $status
                                ];
                                break;
                            }
                        }
                    }
                }
            }
        }
        return collect($temp_data);
    }
    public function headings(): array
    {
        $uuid = $this->uuid;
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details != null) {
            $title = "Nomination Start & End Date: ";
            if (isset($check_details->getNomination)) {
                $title .= Carbon::parse($check_details->getNomination->start_date)->format('d F Y');
            }
            $title .= " to ";
            if (isset($check_details->getNomination)) {
                $title .= Carbon::parse($check_details->getNomination->end_date)->format('d F Y');
            }
            $title .= "\n Nomination Name: ";
            if (isset($check_details->getNomination)) {
                $title .= $check_details->getNomination->name;
            }
            $title .= "\n Membership Type: ";
            if (isset($check_details->getPosition)) {
                $title .= $check_details->getPosition->getMembershipType->membership_type;
            }
            $title .= "\n Position: ";
            if (isset($check_details->getPosition)) {
                $title .= $check_details->getPosition->membership_position;
            }
        } else {
            $title = ' ';
        }

        return [
            [$title, ' ', ' ', ' ', ' '],
            ['Id', 'Member Name', 'Total Vote', 'Total Vote in %', 'Status'],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:E1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:E2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells('A1:E1');
            },
        ];
    }
}
