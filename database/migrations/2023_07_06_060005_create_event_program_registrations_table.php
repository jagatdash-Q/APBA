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
        Schema::create('event_program_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('event_registration_uuid')->nullable();
            $table->string('event_workshop_id')->nullable();
            $table->string('event_program_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_program_registrations');
    }
};
