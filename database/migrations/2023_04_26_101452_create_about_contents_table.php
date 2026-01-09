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
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywoard')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('heading')->nullable();
            $table->string('banner')->nullable();
            $table->string('welcome_head')->nullable();
            $table->text('welcome_desc')->nullable();
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
        Schema::dropIfExists('about_contents');
    }
};
