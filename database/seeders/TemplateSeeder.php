<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            'Home',
            'About',
            'Resources',
            'Membership',
            'Contact Us',
        ];
        foreach ($templates as $temp) {
            $check_temp = Template::where('template_name', $temp)->first();
            if ($check_temp == null) {
                Template::create([
                    'template_name' => $temp,
                    'template_slug' => Str::slug($temp)
                ]);
            }
        }
    }
}
