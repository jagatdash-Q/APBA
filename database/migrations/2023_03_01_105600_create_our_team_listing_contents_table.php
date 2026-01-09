<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamListingContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_team_listing_contents', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->string('our_teams_listing_uid')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywoard')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('about_title',255)->nullable();
            $table->string('image',255)->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('description_data')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('our_team_listing_contents');
    }
}
