<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMember implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        $temp_data = [];
        $members = Customer::query();
        if ($this->data['subscription_status'] != null)
            $members = $members->where('current_subscription_status', $this->data['subscription_status']);
        if ($this->data['year'] != null)
            $members = $members->whereYear('active_subscription_expired_on', $this->data['year']);

        $members = $members->get();
        if (count($members) > 0) {
            $count = 1;
            foreach ($members as $value) {

                // Check subscription details

                $subscription_details = CustomerSubscription::where('customer_id',$value->id)->where('membership_id',$value->active_subscription)->orderBy('id', 'desc')->first();
                if($subscription_details!=null){
                    $subscription_year = Carbon::parse($subscription_details->created_at)->format('l m d,Y');
                }else{
                    $subscription_year =null;
                }


                $payment_amount = Payment::where('customer_id', $value->id)->where('subscription_id', $value->active_subscription)->orderBy('id', 'desc')->first('total_amount');
                if ($payment_amount == null)
                    $value->amount = null;
                else
                    $value->amount = $payment_amount->total_amount;

                if ($value->current_subscription_status == 'a')
                    $status = "Active";
                elseif ($value->current_subscription_status == 'p')
                    $status = "Pending";
                elseif ($value->current_subscription_status == 'e')
                    $status = "Expire";
                else
                    $status = "";

                if (isset($value->getActiveSubscriptionDetails))
                    $membership_name = $value->getActiveSubscriptionDetails->membership_name == null ? null : $value->getActiveSubscriptionDetails->membership_name;
                else
                    $membership_name = null;

                $temp_data[] = [$value->id, $value->user_name, $value->email, $value->country, $value->social_media_link, $value->is_verify_email == '0' ? 'No' : 'Yes', $value->nomination, $membership_name, "S$ " . $value->amount, $status,$subscription_year, Carbon::parse($value->active_subscription_expired_on)->format('l m d,Y')];
                $count++;
            }
        }
        return collect($temp_data);
    }
    public function headings(): array
    {
        return ['ID', 'Member Name', 'Email', 'Country', 'Social Media Link', 'Email Verification Status', 'Nomination', 'Subscription Type', 'Subscription Amount', 'Subscription Status', 'Subscription Year', 'Subscription Expire On'];
    }
}
