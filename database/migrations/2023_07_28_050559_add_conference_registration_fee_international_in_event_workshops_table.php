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
            $table->double('conference_registration_fee_international', 10, 2)->nullable()->default(0)->after('conference_registration_fee');
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
