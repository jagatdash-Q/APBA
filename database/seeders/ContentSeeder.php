<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a minimal "home" content record used by the frontend
        Content::create([
            'template_id' => 'home',
            'template_type' => 'home',
            'created_by' => 1,
            'content_status' => 1,
        ]);
    }
}
