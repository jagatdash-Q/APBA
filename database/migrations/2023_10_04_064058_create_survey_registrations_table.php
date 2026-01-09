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
        Schema::create('survey_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('event_program_registration_uuid')->nullable();
            $table->string('survey_activity_uuid')->nullable();
            $table->string('fullname')->nullable();
            $table->string('organization')->nullable();
            $table->string('email')->nullable();
            $table->string('content_material')->comment('Course content and material')->nullable();
            $table->string('speaker_knowledge')->comment('Speakers\' knowledge and competency')->nullable();
            $table->string('trainer_presentation')->comment('Trainer\'s presentation skill')->nullable();
            $table->string('q_a_session')->comment('Q&A session - Effectiveness')->nullable();
            $table->string('overall_delivery')->comment('Overall delivery and effectiveness')->nullable();
            $table->string('conference_content')->comment('Conference content and material')->nullable();
            $table->string('conference_relevant')->comment('Is the content of the Conference/Workshop relevant to your area(s) of work? Why?')->nullable();
            $table->string('future_conference')->comment('What other area(s) or topic(s) would you like to see being included in future Conference/Workshop?')->nullable();
            $table->string('feedback')->comment('Any additional comments or feedback on the Conference/Workshop
            or
            speakers?')->nullable();
            $table->string('survey_url')->nullable();
            $table->enum('certificate_sent', ['yes', 'no'])->nullable();
            $table->string('certificate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_registrations');
    }
};
