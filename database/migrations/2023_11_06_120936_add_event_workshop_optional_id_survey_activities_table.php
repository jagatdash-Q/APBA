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
        Schema::table('survey_activities', function (Blueprint $table) {
            //
            $table->integer('event_workshop_optional_id')->nullable()->after('event_workshop_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_activities', function (Blueprint $table) {
            //
        });
    }
};
