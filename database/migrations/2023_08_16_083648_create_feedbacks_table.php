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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 27)->nullable(false)->comment('full name person');
            $table->string('phone', 25)->nullable(false)->comment('phone number');
            $table->foreignId('city_id')->comment('city title');
            $table->text('feedback')->nullable(false)->comment('feedback client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_backs');
    }
};
