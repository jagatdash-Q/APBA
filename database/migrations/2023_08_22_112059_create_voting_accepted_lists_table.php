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
        Schema::create('voting_accepted_lists', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('voting_uuid')->nullable();
            $table->string('voting_position_uuid')->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('approved_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_accepted_lists');
    }
};
