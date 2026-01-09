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
        Schema::create('event_workshop_optionals', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable();
            $table->string('activity_optional_name')->nullable();
            $table->double('activity_optional_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_workshop_optionals');
    }
};
