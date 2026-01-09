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
            $table->dropColumn('conference_registration_fee');
            $table->dropColumn('networking_dinner_fee');
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
