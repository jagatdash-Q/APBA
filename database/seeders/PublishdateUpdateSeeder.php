<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublishdateUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all_events = Event::all();
        foreach($all_events as $val){
            if($val->publish_date!=''){
                Event::whereId($val->id)->update(['publish_date'=>Date('Y-m-d')]);
            }
        }
    }
}
