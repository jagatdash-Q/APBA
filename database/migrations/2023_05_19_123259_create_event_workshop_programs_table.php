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
        Schema::create('event_workshop_programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id')->nullable();
            $table->integer('event_workshop_id')->nullable();
            $table->string('program_name')->nullable();
            $table->string('program_slug')->nullable();
            $table->text('program_desc')->nullable();
            $table->text('program_trainers')->nullable();
            $table->integer('workshop_number')->nullable();
            $table->integer('room_no')->nullable();
            $table->double('price_member',10,2)->nullable();
            $table->double('price_guest',10,2)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->enum('status',['0','1'])->default('1')->comment('0-> deactivate , 1 -> activate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_workshop_programs');
    }
};
