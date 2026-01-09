<?php

namespace App\Exports;

use App\Models\CustomerNomination;
use App\Models\NominationPosition;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportCustomerNomination implements FromCollection, WithHeadings, WithEvents
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
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details != null) {
            $customer_nomination = CustomerNomination::with(['getMemberName', 'getCustomer'])->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $member_id)->get();
            if (count($customer_nomination) > 0) {
                foreach ($customer_nomination as $value) {

                    if ($value->getCustomer->current_subscription_status == 'a')
                        $status = "Active";
                    elseif ($value->getCustomer->current_subscription_status == 'p')
                        $status = "Pending";
                    elseif ($value->getCustomer->current_subscription_status == 'e')
                        $status = "Expire";
                    else
                        $status = "";

                    if (isset($value->getCustomer->getActiveSubscriptionDetails))
                        $membership_name = $value->getCustomer->getActiveSubscriptionDetails->membership_name == null ? null : $value->getCustomer->getActiveSubscriptionDetails->membership_name;
                    else
                        $membership_name = null;


                    $temp_data[] = [$value->getCustomer->first_name . " " . $value->getCustomer->last_name, $value->getCustomer->email, $value->getCustomer->is_verify_email == '0' ? 'No' : 'Yes', $value->getCustomer->nomination, $membership_name, $status, Carbon::parse($value->getCustomer->active_subscription_expired_on)->format('d F Y')];
                }
            }
        }
        return collect($temp_data);
    }
    public function headings(): array
    {
        $uuid = $this->uuid;
        $member_id = $this->member_id;
        $check_details = NominationPosition::with(['getPosition', 'getNomination'])->where('uuid', $uuid)->first();
        if ($check_details != null) {
            $customer_nomination = CustomerNomination::with('getMemberName')->where('nomination_uuid', $check_details->nomination_uuid)->where('nomination_position_uuid', $check_details->position_uuid)->where('member_id', $member_id)->get();
            $title = "Nomination Start & End Date: ";
            if (isset($check_details->getNomination))
                $title .= Carbon::parse($check_details->getNomination->start_date)->format('d F Y');
            $title .= " to ";
            if (isset($check_details->getNomination))
                $title .= Carbon::parse($check_details->getNomination->end_date)->format('d F Y');
            $title .= "\n Nomination Name: ";
            if (isset($check_details->getNomination))
                $title .= $check_details->getNomination->name;
            $title .= "\n Membership Type: ";
            if (isset($check_details->getPosition))
                $title .= $check_details->getPosition->getMembershipType->membership_type;
            $title .= "\n Position: ";
            if (isset($check_details->getPosition))
                $title .= $check_details->getPosition->membership_position;
            $title .= "\n Member Name: ";
            if (count($customer_nomination))
                $title .= $customer_nomination[0]->getMemberName->user_name;
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
