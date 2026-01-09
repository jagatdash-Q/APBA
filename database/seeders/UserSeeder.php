<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $admin = [
            'name' => "superadmin",
            'email' => "superadmin@apba.com",
            'password' => Hash::make("superadmin"),
            'email_verified_at' => now(),
        ];
        $user_admin = User::create($admin);
        $user_admin->addRole('superadmin');
        $admin = [
            'name' => "admin",
            'email' => "secretariat@a-pba.org",
            'password' => Hash::make("Oq3QQxlo9pK7"),
            'email_verified_at' => now(),
        ];
        $user_admin = User::create($admin);
        $user_admin->addRole('admin');
    }
}
