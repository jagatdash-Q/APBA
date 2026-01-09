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
        Schema::dropIfExists('event_basic_details');
        Schema::dropIfExists('event_bio_safty_course_and_exam_details');
        Schema::dropIfExists('event_pre_conf_visa_info_details');
        Schema::dropIfExists('event_speaker_description_images');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
