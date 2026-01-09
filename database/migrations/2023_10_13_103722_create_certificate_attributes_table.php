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
        Schema::create('certificate_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('logo_1')->nullable();
            $table->string('logo_2')->nullable();
            $table->string('signature_1')->nullable();
            $table->string('signature_2')->nullable();
            $table->string('introducer_name_1')->nullable();
            $table->string('introducer_name_2')->nullable();
            $table->string('introducer_company_1')->nullable();
            $table->string('introducer_company_2')->nullable();
            $table->string('background_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_attributes');
    }
};
