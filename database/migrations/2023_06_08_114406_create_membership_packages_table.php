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
        Schema::create('membership_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('membership_contents_id')->nullable();
            $table->string('membership_name')->nullable();
            $table->string('membership_srt_desc')->nullable();
            $table->enum('subscription_type',['sub','con'])->nullable()->comment(' sub-> customer needs to subscribe this package , con-> user has to fill contact form to subscribe to this package');
            $table->string('membership_image')->nullable();
            $table->string('membership_button_text')->nullable();
            $table->longText('membership_description')->nullable();
            $table->double('membership_price',10,2)->nullable();
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
        Schema::dropIfExists('membership_pcakages');
    }
};
