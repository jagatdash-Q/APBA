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
        Schema::create('event_tab_buttons', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable();
            $table->integer('event_tab_id')->nullable();
            $table->string('button_title')->nullable();
            $table->string('button_label')->nullable();
            $table->text('button_link')->nullable();
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
        Schema::dropIfExists('event_tab_buttons');
    }
};
