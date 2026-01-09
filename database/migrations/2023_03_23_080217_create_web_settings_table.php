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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_logo')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('site_name')->nullable();
            $table->string('site_email')->nullable();
            $table->string('site_copyrights')->nullable();
            $table->string('site_title')->nullable();
            $table->string('site_address')->nullable();

            $table->string('fb_link')->nullable();
            $table->string('insta_link')->nullable();
            $table->string('linkdn_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
