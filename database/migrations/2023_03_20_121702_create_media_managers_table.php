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
        Schema::create('media_managers', function (Blueprint $table) {

            $table->id();
            $table->string('media_uid', 191);
            $table->string('media_url', 191)->nullable()->default('NULL');
            $table->string('path', 191)->nullable()->default('NULL');
            $table->string('file_type', 191)->nullable()->default('NULL');
            $table->string('file_ext', 191)->nullable()->default('NULL');
            $table->string('file_name', 191)->nullable()->default('NULL');
            $table->string('alt_tag', 191)->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('media_managers');
    }
};
