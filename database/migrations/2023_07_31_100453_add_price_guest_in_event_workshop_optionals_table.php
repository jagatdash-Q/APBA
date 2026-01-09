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
            $table->double('price_guest', 10, 2)->default(0)->after('price_member');
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
