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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->date('date_publication');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut');
            $table->boolean('premium')->default(false);
            $table->string('adresse');
            $table->foreignId('objet_id')->constrained();
            $table->foreignId('proprietaire_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
