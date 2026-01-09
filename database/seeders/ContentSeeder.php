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
        $content = Content::create([
            'template_id' => 'home',
            'template_type' => 'home',
            'created_by' => 1,
            'content_status' => 1,
        ]);

        // also create a basic HomeContent row if the model/table exists
        if (class_exists(\App\Models\HomeContent::class)) {
            \App\Models\HomeContent::create([
                'content_id' => $content->id,
                'page_name' => 'Home',
                'page_slug' => 'home',
            ]);
        }
    }
}
