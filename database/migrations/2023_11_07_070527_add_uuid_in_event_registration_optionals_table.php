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
        Schema::table('event_registration_optionals', function (Blueprint $table) {
            $table->string('uuid')->after('id')->nullable();
            $table->enum('survey', ['yes', 'no'])->default('no')->after('event_workshop_optional_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registration_optionals', function (Blueprint $table) {
            //
        });
    }
};
