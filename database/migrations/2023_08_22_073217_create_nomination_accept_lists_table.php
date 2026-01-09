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
        Schema::create('nomination_accept_lists', function (Blueprint $table) {
            $table->id();
            $table->string('nomination_uuid')->nullable();
            $table->string('nomination_position_uuid')->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('accepted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomination_accept_lists');
    }
};
