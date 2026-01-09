<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\EventRegistration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::truncate();
        EventRegistration::truncate();

        $path = public_path('apba_db_event_registrations.sql');
        $specialmember_sql = file_get_contents($path);
        DB::unprepared($specialmember_sql);

        $path = public_path('apba_db_customers.sql');
        $specialmember_sql = file_get_contents($path);
        DB::unprepared($specialmember_sql);
    }
}
