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
        Schema::create('resource_menus', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('resource_uuid')->nullable();
            $table->string('menu')->nullable();
            $table->integer('section_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_menus');
    }
};
