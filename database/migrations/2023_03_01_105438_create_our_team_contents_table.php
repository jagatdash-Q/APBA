<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_team_contents', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->string('our_teams_uid')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywoard')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('title')->nullable();
            $table->string('desc',512)->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_head')->nullable();
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
        Schema::dropIfExists('our_team_contents');
    }
}
