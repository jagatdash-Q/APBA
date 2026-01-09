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
        Schema::table('our_team_contents', function (Blueprint $table) {
            $table->string('banner_desc')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_name')->nullable();
            $table->renameColumn('banner_image','banner_image_web')->nullable();
            $table->string('banner_image_tablet')->nullable();
            $table->string('banner_image_mobile')->nullable();
            $table->decimal('banner_title_left_pos_web',5,2)->nullable();
            $table->decimal('banner_title_top_pos_web',5,2)->nullable();
            $table->decimal('banner_desc_left_pos_web',5,2)->nullable();
            $table->decimal('banner_desc_top_pos_web',5,2)->nullable();
            $table->decimal('button_name_left_pos_web',5,2)->nullable();
            $table->decimal('button_name_top_pos_web',5,2)->nullable();
            $table->decimal('banner_title_left_pos_tablet',5,2)->nullable();
            $table->decimal('banner_title_top_pos_tablet',5,2)->nullable();
            $table->decimal('banner_desc_left_pos_tablet',5,2)->nullable();
            $table->decimal('banner_desc_top_pos_tablet',5,2)->nullable();
            $table->decimal('button_name_left_pos_tablet',5,2)->nullable();
            $table->decimal('button_name_top_pos_tablet',5,2)->nullable();
            $table->decimal('banner_title_left_pos_mobile',5,2)->nullable();
            $table->decimal('banner_title_top_pos_mobile',5,2)->nullable();
            $table->decimal('banner_desc_left_pos_mobile',5,2)->nullable();
            $table->decimal('banner_desc_top_pos_mobile',5,2)->nullable();
            $table->decimal('button_name_left_pos_mobile',5,2)->nullable();
            $table->decimal('button_name_top_pos_mobile',5,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
