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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('country')->nullable();
            $table->string('password')->nullable();
            $table->enum('is_verify_email',['0','1'])->default('0')->comment('0->not verified , 1-> Verified');
            $table->timestamp('registered_on')->nullable();
            $table->timestamp('email_verified_on')->nullable();
            $table->string('email_token')->nullable();
            $table->enum('register_by',['i','r'])->default('r')->comment('i -> import with file as they were old customers, r-> Self register in site');
            $table->enum('current_subscription_status',['a','e'])->default('a')->comment('a -> active, e-> expired');
            $table->enum('is_term_accept',['y','n'])->default('y')->comment('y -> yes, n-> no');
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('active_subscription')->nullable();
            $table->timestamp('active_subscription_expired_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
