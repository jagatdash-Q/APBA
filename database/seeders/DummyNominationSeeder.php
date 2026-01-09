<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerNomination;
use App\Models\MembershipPackage;
use App\Models\MembershipPosition;
use App\Models\MembershipType;
use App\Models\Nomination;
use App\Models\NominationAcceptList;
use App\Models\NominationPosition;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DummyNominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {

            // Truncate required tables

            MembershipType::truncate();
            MembershipPosition::truncate();
            Nomination::truncate();
            NominationPosition::truncate();
            CustomerNomination::truncate();
            NominationAcceptList::truncate();

            // Get corporate membership details

            // $is_membership_exist = MembershipPackage::where('membership_name','Corporate')->first();

            // Create membership type 
            try {

                $member_ship_type = ['A-PBA Office-bearers', 'Committee Members', 'Honorary Auditors'];
                for ($i = 0; $i < count($member_ship_type); $i++) {
                    $is_membership_create = MembershipType::create([
                        'uuid' => Str::uuid()->toString(),
                        'membership_type' => $member_ship_type[$i],
                        'status' => '1'
                    ]);
                }
            } catch (Exception $e) {
                Log::error("MembershipType create error : " . $e->getMessage());
            }



            // Create membership postions 
            try {

                $all_member_ship_types = MembershipType::where('status', '1')->get();
                $position_arr = ['President', 'Vice President', 'Secretary', 'Assistant Secretary', 'Treasurer'];
                if (count($all_member_ship_types)) {
                    foreach ($all_member_ship_types as $val) {
                        foreach ($position_arr as $value) {
                            MembershipPosition::create([
                                'uuid' => Str::uuid()->toString(),
                                'membership_type_uuid' => $val->uuid,
                                'membership_position' => $value
                            ]);
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error("MembershipPosition create error : " . $e->getMessage());
            }




            // Create nomination
            try {

                $nomination_names = ['President of 2023', 'Vice President of 2023', 'Secretary of 2023'];
                for ($i = 0; $i <count($nomination_names); $i++) {
                    $is_nomination_create = Nomination::create([
                        'uuid' => Str::uuid()->toString(),
                        'name' => $nomination_names[$i],
                        'start_date' => date('Y-m-d'),
                        'end_date' => Carbon::now()->addMonth()->format('Y-m-d'),
                        'status' => "1",
                        'created_by' => 1
                    ]);
                    if ($is_nomination_create) {
                        //get Membership Position
                        $is_position_exist = MembershipPosition::whereId(($i+1))->first();
                        if ($is_position_exist != null) {
                            NominationPosition::create([
                                'uuid' => Str::uuid()->toString(),
                                'nomination_uuid' => $is_nomination_create->uuid,
                                'position_uuid' => $is_position_exist->uuid
                            ]);
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error("NominationPosition create error : " . $e->getMessage());
            }




            // create customer nomination
            try {
                $customers = Customer::with('getActiveSubscriptionDetails')->where('nomination', 'yes')->get();
                foreach ($customers as $val) {

                    $nomination = NominationPosition::inRandomOrder()->first();
                    if ($nomination != null) {

                        // Get random customer
                        $customer_exist = Customer::where('nomination', 'yes')->inRandomOrder()->first();

                        if ($customer_exist != null) {
                            // Check if customer nominated or not 
                            $is_nominated = CustomerNomination::where('customer_id', $val->id)->where('member_id', $customer_exist->id)->where('nomination_uuid', $nomination->nomination_uuid)->where('nomination_position_uuid', $nomination->position_uuid)->first();

                            if ($is_nominated == null) {
                                CustomerNomination::create([
                                    'customer_id' => $val->id,
                                    'member_id' => $customer_exist->id,
                                    'nomination_uuid' => $nomination->nomination_uuid,
                                    'nomination_position_uuid' => $nomination->position_uuid
                                ]);
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error("CustomerNomination create error : " . $e->getMessage());
            }







            // create Nomination accepted list
            try {
                $unique_customer_nominations = CustomerNomination::distinct('member_id')->distinct('nomination_position_uuid')->inRandomOrder()->limit(10)->get();

                foreach ($unique_customer_nominations as $val) {
                    $is_accepted_list_create = NominationAcceptList::where('nomination_uuid', $val->nomination_uuid)->where('nomination_position_uuid', $val->nomination_position_uuid)->where('member_id', $val->member_id)->first();
                    if ($is_accepted_list_create == null) {
                        NominationAcceptList::create([
                            'nomination_uuid' => $val->nomination_uuid,
                            'nomination_position_uuid' => $val->nomination_position_uuid,
                            'member_id' => $val->member_id,
                            'accepted_by' => 1
                        ]);
                    }
                }
            } catch (Exception $e) {
                Log::error("NominationAcceptList create error : " . $e->getMessage());
            }
        } catch (Exception $e) {

            Log::error("CustomerNomination : " . $e->getMessage());
        }
    }
}
