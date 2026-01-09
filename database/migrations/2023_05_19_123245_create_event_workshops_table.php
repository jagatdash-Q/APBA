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
        Schema::create('event_workshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id')->nullable();
            $table->string('workshop_name')->nullable();
            $table->string('workshop_slug')->nullable();
            $table->date('workshop_date')->nullable();
            $table->string('workshop_desc')->nullable();
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
        Schema::dropIfExists('event_workshops');
    }
};
