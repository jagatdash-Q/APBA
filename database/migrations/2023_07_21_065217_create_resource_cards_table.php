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
        Schema::create('resource_cards', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('resource_uuid')->nullable();
            $table->string('resource_menu_uuid')->nullable();
            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->string('hover_icon')->nullable();
            $table->string('link')->nullable();
            $table->enum('status', ['0', '1'])->comment('0=>private 1=>public')->nullable();
            $table->integer('section_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_cards');
    }
};
