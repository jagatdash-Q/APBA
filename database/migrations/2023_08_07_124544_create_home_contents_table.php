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
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('banner_image_web')->nullable();
            $table->string('banner_image_tablet')->nullable();
            $table->string('banner_image_mobile')->nullable();
            $table->string('section_1_img_1')->nullable();
            $table->string('section_1_img_2')->nullable();
            $table->string('section_1_heading')->nullable();
            $table->string('section_1_button_text')->nullable();
            $table->text('section_1_button_link')->nullable();
            $table->longText('section_1_desc')->nullable();
            $table->string('section_2_heading')->nullable();
            $table->longText('section_2_desc')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
