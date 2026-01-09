<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::get();
        if (count($customer) > 0) {
            foreach ($customer as $value) {
                $value->user_name = $value->first_name . " " . $value->last_name;
                $value->save();
            }
        }
    }
}
