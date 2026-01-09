<?php

namespace Database\Seeders;

use App\Models\EventRegistrationOptional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UuidInsertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $get_optional = EventRegistrationOptional::get();
        if (count($get_optional)) {
            foreach ($get_optional as $value) {
                $value->uuid = Str::uuid()->toString();
                $value->save();
            }
        }
    }
}
