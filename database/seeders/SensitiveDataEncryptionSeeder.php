<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\EventRegistration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class SensitiveDataEncryptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event_reg = DB::select('SELECT * FROM `eventregistrations`');
        if (count($event_reg)) {
            foreach ($event_reg as $val) {
                $reg = new EventRegistration();
                $reg->id = $val->id;
                $reg->uuid = $val->uuid;
                $reg->first_name = $val->first_name;
                $reg->last_name = $val->last_name;
                $reg->email = $val->email;
                $reg->contact_number = $val->contact_number;
                $reg->customer_id = $val->customer_id;
                $reg->event_id = $val->event_id;
                $reg->total_amount = $val->total_amount;
                $reg->conference_registration_fee = $val->conference_registration_fee;
                $reg->networking_dinner_fee = $val->networking_dinner_fee;
                $reg->payment_status = $val->payment_status;
                $reg->survey = $val->survey;
                $reg->organisation_name = $val->organisation_name;
                $reg->organisation_address = $val->organisation_address;
                $reg->phone_code = $val->phone_code;
                $reg->created_at = $val->created_at;
                $reg->updated_at = $val->updated_at;
                $reg->save();
            }
        }
        Schema::dropIfExists('eventregistrations');
        $event_reg = DB::select('SELECT * FROM `customer`');
        if (count($event_reg)) {
            foreach ($event_reg as $val) {
                $reg = new Customer();
                $reg->id = $val->id;
                $reg->first_name = $val->first_name;
                $reg->last_name = $val->last_name;
                $reg->user_name = $val->user_name;
                $reg->profile_pic = $val->profile_pic;
                $reg->social_media_link = $val->social_media_link;
                $reg->email = $val->email;
                $reg->country = $val->country;
                $reg->password = $val->password;
                $reg->is_verify_email = $val->is_verify_email;
                $reg->registered_on = $val->registered_on;
                $reg->email_verified_on = $val->email_verified_on;
                $reg->email_token = $val->email_token;
                $reg->register_by = $val->register_by;
                $reg->current_subscription_status = $val->current_subscription_status;
                $reg->is_term_accept = $val->is_term_accept;
                $reg->created_by = $val->created_by;
                $reg->deleted_by = $val->deleted_by;
                $reg->active_subscription = $val->active_subscription;
                $reg->active_subscription_expired_on = $val->active_subscription_expired_on;
                $reg->nomination = $val->nomination;
                $reg->created_at = $val->created_at;
                $reg->updated_at = $val->updated_at;
                $reg->save();
            }
        }
        Schema::dropIfExists('customer');
    }
}
