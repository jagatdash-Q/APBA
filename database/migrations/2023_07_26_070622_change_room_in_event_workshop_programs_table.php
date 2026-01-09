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
        Schema::table('event_workshop_programs', function (Blueprint $table) {
            $table->string('room_no')->change();
            $table->string('workshop_number')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_workshop_programs', function (Blueprint $table) {
            //
        });
    }
};
