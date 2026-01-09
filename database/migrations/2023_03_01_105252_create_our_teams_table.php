<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->integer('lock_acquired_by')->nullable();
            $table->enum('page_type',['our_teams'])->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('edited_by')->nullable();
            $table->integer('reviewed_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->text('reject_remarks')->nullable();
            $table->enum('content_status',['0','1','2','3','4'])->nullable()->comments(['0 -> Draft', '1 -> Approved/publish', '2 -> Under_review', '3 -> WIP', '4 -> Unpublish']);
            $table->softDeletes();
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
        Schema::dropIfExists('our_teams');
    }
}
