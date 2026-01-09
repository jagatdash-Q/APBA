<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamCategoryContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_team_category_contents', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->string('category_uid')->nullable();
            $table->string('title')->nullable();
            $table->string('page_slug')->nullable();
            $table->enum('status', ['0', '1'])->nullable()->comment('0 -> inactive , 1 -> active');
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
        Schema::dropIfExists('our_team_category_contents');
    }
}
