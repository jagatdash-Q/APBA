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
        Schema::create('event_basic_details', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable();
            $table->string('event_intro_tab_name')->nullable();
            $table->string('event_intro_title')->nullable();
            $table->text('event_intro_desc')->nullable();
            $table->string('conference_highlight_tab_name')->nullable();
            $table->string('conference_highlight_title')->nullable();
            $table->text('conference_highlight_desc')->nullable();
            $table->string('conference_registration_rate_tab_name')->nullable();
            $table->string('conference_registration_rate_title')->nullable();
            $table->text('conference_registration_rate_desc')->nullable();
            $table->text('conference_registration_rate_desc_data')->nullable();
            $table->string('who_should_attend_tab_name')->nullable();
            $table->string('who_should_attend_title')->nullable();
            $table->text('who_should_attend_desc')->nullable();
            $table->text('who_should_attend_desc_data')->nullable();
            $table->string('pre_conf_and_visa_info_tab_name')->nullable();
            $table->string('pre_conf_and_visa_info_title')->nullable();
            $table->string('bio_safty_course_and_exam_tab_name')->nullable();
            $table->string('bio_safty_course_and_exam_title')->nullable();
            $table->string('bio_safty_course_and_exam_image')->nullable();
            $table->string('poster_submission_tab_name')->nullable();
            $table->string('poster_submission_title')->nullable();
            $table->text('poster_submission_desc')->nullable();
            $table->string('poster_submission_btn_name')->nullable();
            $table->string('poster_submission_btn_link')->nullable();
            $table->string('featured_speaker_tab_name')->nullable();
            $table->string('featured_speaker_title')->nullable();
            $table->string('hotel_venue_tab_name')->nullable();
            $table->string('hotel_venue_title')->nullable();
            $table->string('hotel_venue_image')->nullable();
            $table->text('hotel_venue_address')->nullable();
            $table->string('hotel_venue_tel')->nullable();
            $table->string('hotel_venue_reservation')->nullable();
            $table->string('hotel_venue_fax')->nullable();
            $table->string('hotel_venue_web_link')->nullable();
            $table->text('hotel_venue_desc')->nullable();
            $table->string('sponsorship_tab')->nullable();
            $table->string('sponsorship_title')->nullable();
            $table->text('sponsorship_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_basic_details');
    }
};
