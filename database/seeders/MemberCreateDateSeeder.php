<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberCreateDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::with(['getActiveSubscriptionDetails', 'getSubscriptionHistory'])->get();
        if (count($customer) > 0) {

            foreach ($customer as $value) {

                if ($value->active_subscription != null && $value->getActiveSubscriptionDetails != null) {
                    if ($value->getActiveSubscriptionDetails->membership_name == "Life Time Membership") {
                        $dateObject = new DateTime($value->active_subscription_expired_on);
                        $dateObject->setDate(2219, $dateObject->format('m'), $dateObject->format('d'));
                        $value->active_subscription_expired_on = $dateObject->format('Y-m-d');
                        $value->save();
                    }
                    if ($value->getActiveSubscriptionDetails->membership_name == "Corporate Membership") {
                        $value->nomination = 'no';
                        $value->save();
                    }
                }
                $expire_year = $value->active_subscription_expired_on;
                if ($expire_year != null) {
                    $year = Carbon::parse($expire_year)->format('Y');
                    if ($year == 1970) {
                        $value->active_subscription_expired_on = null;
                        $value->save();
                    }
                }

                if ($value->getSubscriptionHistory != null && count($value->getSubscriptionHistory)) {
                    foreach ($value->getSubscriptionHistory as $subscription) {
                        $subscription_year = Carbon::parse($subscription->subscription_expired_on)->format('Y');
                        if ($subscription_year == 1970) {
                            $subscription->subscription_expired_on = null;
                            $subscription->save();
                        }
                    }
                }

                if ($value->active_subscription_expired_on != null) {
                    $replaceYear = Carbon::parse($value->active_subscription_expired_on)->format('Y');
                    if ($replaceYear != 2219) {
                        $value->created_at = Carbon::parse($value->active_subscription_expired_on)->subYear();
                        $value->save();
                    }
                }

            }
        }
    }
}
