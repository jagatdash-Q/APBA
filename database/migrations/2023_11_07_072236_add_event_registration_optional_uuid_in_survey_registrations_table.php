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
        Schema::table('survey_registrations', function (Blueprint $table) {
            $table->string('event_registration_optional_uuid')->nullable()->after('event_program_registration_uuid');
            $table->string('type')->nullable()->after('certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_registrations', function (Blueprint $table) {
            //
        });
    }
};
