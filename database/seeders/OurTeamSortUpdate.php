<?php

namespace Database\Seeders;

use App\Models\OurTeamListing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurTeamSortUpdate extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $our_team_listing = OurTeamListing::all();

        foreach($our_team_listing as $val){
            OurTeamListing::whereId($val->id)->update(['sort_no'=>$val->id]);
        }

    }
}
