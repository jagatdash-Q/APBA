<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_bio_safty_course_and_exam_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id')->nullable();
            $table->string('title')->nullable();
            $table->string('button_name')->nullable();
            $table->string('pdf')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_bio_safty_course_and_exam_details');
    }
};
