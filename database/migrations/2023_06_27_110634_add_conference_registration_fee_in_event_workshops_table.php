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
        Schema::table('event_workshops', function (Blueprint $table) {
            $table->double('conference_registration_fee', 10, 2)->nullable()->after('workshop_desc')->default(0);
            $table->double('networking_dinner_fee', 10, 2)->nullable()->after('conference_registration_fee')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_workshops', function (Blueprint $table) {
            //
        });
    }
};
