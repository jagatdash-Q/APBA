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
        Schema::create('about_content_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable();
            $table->string('section_id')->nullable();
            $table->integer('sort_no')->nullable();
            $table->string('image')->nullable();
            $table->text('desc')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_content_temps');
    }
};
