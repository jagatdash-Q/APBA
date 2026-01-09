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
        Schema::create('home_first_section_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('content_id')->nullable();
            $table->string('home_content_uuid')->nullable();
            $table->string('uuid')->nullable();
            $table->string('image')->nullable();
            $table->string('heading')->nullable();
            $table->longText('description')->nullable();
            $table->string('view_more_text')->nullable();
            $table->text('view_more_link')->nullable();
            $table->enum('is_active',['0','1'])->default('1')->comment('0 -> not active , 1 -> active');
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
        Schema::dropIfExists('home_first_section_cards');
    }
};
