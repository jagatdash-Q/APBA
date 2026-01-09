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
        Schema::create('survey_reminders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('survey_activity_uuid')->nullable();
            $table->string('event_registration_uuid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_reminders');
    }
};
