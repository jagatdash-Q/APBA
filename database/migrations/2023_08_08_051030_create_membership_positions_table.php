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
        Schema::create('membership_positions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('membership_type_uuid')->nullable();
            $table->string('membership_position')->nullable();
            $table->enum('status', ['0', '1'])->comment('0->inactive, 1->active')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_positions');
    }
};
