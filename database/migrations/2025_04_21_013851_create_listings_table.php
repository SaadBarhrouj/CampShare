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
            $table->foreignId('partner_id')->constrained('users');
            $table->foreignId('city_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->decimal('price_per_day', 8, 2);
            $table->enum('status', ['active', 'archived', 'inactive']);
            $table->boolean('is_premium')->default(false);
            $table->date('premium_start_date');
            $table->date('premium_end_date');
            $table->foreignId('category_id')->constrained();
            $table->boolean('delivery_option')->default(false);
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
