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
        Schema::create('customer_password_resets', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_link_sent_on')->nullable();
            $table->timestamp('password_reset_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_password_resets');
    }
};
