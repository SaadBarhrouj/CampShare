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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('city_id')->constrained();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->boolean('delivery_option')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->enum('premium_type', ['7 jours', '15 jours', '30 jours'])->nullable();
            $table->date('premium_start_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
