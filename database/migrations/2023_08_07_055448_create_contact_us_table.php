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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_desc')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_name')->nullable();
            $table->string('banner_image_web')->nullable();
            $table->string('banner_image_tablet')->nullable();
            $table->string('banner_image_mobile')->nullable();
            $table->decimal('banner_title_left_pos_web', 5, 2)->nullable();
            $table->decimal('banner_title_top_pos_web', 5, 2)->nullable();
            $table->decimal('banner_desc_left_pos_web', 5, 2)->nullable();
            $table->decimal('banner_desc_top_pos_web', 5, 2)->nullable();
            $table->decimal('button_name_left_pos_web', 5, 2)->nullable();
            $table->decimal('button_name_top_pos_web', 5, 2)->nullable();
            $table->decimal('banner_title_left_pos_tablet', 5, 2)->nullable();
            $table->decimal('banner_title_top_pos_tablet', 5, 2)->nullable();
            $table->decimal('banner_desc_left_pos_tablet', 5, 2)->nullable();
            $table->decimal('banner_desc_top_pos_tablet', 5, 2)->nullable();
            $table->decimal('button_name_left_pos_tablet', 5, 2)->nullable();
            $table->decimal('button_name_top_pos_tablet', 5, 2)->nullable();
            $table->decimal('banner_title_left_pos_mobile', 5, 2)->nullable();
            $table->decimal('banner_title_top_pos_mobile', 5, 2)->nullable();
            $table->decimal('banner_desc_left_pos_mobile', 5, 2)->nullable();
            $table->decimal('banner_desc_top_pos_mobile', 5, 2)->nullable();
            $table->decimal('button_name_left_pos_mobile', 5, 2)->nullable();
            $table->decimal('button_name_top_pos_mobile', 5, 2)->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->text('google_map')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
