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
        Schema::table('event_workshop_optionals', function (Blueprint $table) {
            $table->enum('survey', ['yes', 'no'])->default('no')->after('price_guest');
            $table->string('survey_activity_uuid')->nullable()->after('survey');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_workshop_optionals', function (Blueprint $table) {
            //
        });
    }
};
