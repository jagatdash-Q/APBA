<?php

namespace App\Imports;

use App\Models\Content;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\MembershipContent;
use App\Models\MembershipPackage;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomersImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        try {
            $is_membership_exist = Content::where('template_type', 'membership')->where('content_status', '1')->first();
            if ($is_membership_exist != null) {
                // Check if mebership page created or not ?
                $is_page_exist  = MembershipContent::where('content_id', $is_membership_exist->id)->first();
                if ($is_page_exist != null) {
                    foreach ($rows as $index => $row) {
                        if ($index > 0) {
                            $is_customer_exist = Customer::where('email', $row[0])->first();
                            if ($is_customer_exist == null) {
                                // Check if country exist
                                $country_id = 0;
                                $is_country_exist = Country::where('name', preg_replace('/[^A-Za-z0-9]/', '', $row[3]))->first();
                                if ($is_country_exist == null) {
                                    if (preg_replace('/[^A-Za-z0-9]/', '', $row[3]) != '') {
                                        $is_country_create = Country::create([
                                            'name' => preg_replace('/[^A-Za-z0-9]/', '', $row[3]),
                                            'slug' =>  Str::slug(preg_replace('/[^A-Za-z0-9]/', '', $row[3])),
                                            'status' => '1',
                                            'created_by' => Auth::id(),
                                        ]);
                                        if ($is_country_create) {
                                            $country_id = $is_country_create->id;
                                        }
                                    }
                                } else {
                                    $country_id = $is_country_exist->id;
                                }
                                // Check if package exist or not
                                $is_package_exist = MembershipPackage::where('membership_contents_id', $is_page_exist->id)->where('membership_name', $row[4])->first();
                                if ($is_package_exist != null) {
                                    $token = Str::uuid()->toString();
                                    $current_subscription_status = ($row[6] == 'Active') ? 'a' : 'e';

                                    $date = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$row[7]));
                                    $date = Carbon::parse($date)->format('Y-m-d');
                                    // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])->format('Y-m-d H:i:s'));
                                    $is_customer_create = Customer::create([
                                        'first_name' => $row[1],
                                        'last_name' => $row[2],
                                        'user_name' => $row[0],
                                        'email' => $row[0],
                                        'country' => $country_id,
                                        'password' => '',
                                        'is_verify_email' => '1',
                                        'registered_on' => now(),
                                        'email_verified_on' => now(),
                                        'email_token' => $token,
                                        'current_subscription_status' => $current_subscription_status,
                                        'active_subscription' => $is_package_exist->id,
                                        'active_subscription_expired_on' => $date,
                                        'register_by' => 'i'
                                    ]);
                                    if ($is_customer_create) {
                                        CustomerSubscription::create([
                                            'membership_id' => $is_package_exist->id,
                                            'customer_id' => $is_customer_create->id,
                                            'amount' => $is_package_exist->membership_price,
                                            'subscription_in' => 'csv',
                                            // 'subscribed_on' => now(),
                                            'subscription_expired_on' => $date,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::info('Error in excel import' . $e->getMessage());
        }
    }
}
