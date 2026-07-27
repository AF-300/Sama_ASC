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
    Schema::create('statistiques_joueurs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('joueur_id')->constrained('joueurs')->cascadeOnDelete();
        $table->foreignId('match_id')->constrained('matchs')->cascadeOnDelete();
        $table->unsignedTinyInteger('buts')->default(0);
        $table->unsignedTinyInteger('passes_decisives')->default(0);
        $table->unsignedTinyInteger('cartons_jaunes')->default(0);
        $table->unsignedTinyInteger('cartons_rouges')->default(0);
        $table->timestamps();

        $table->unique(['joueur_id', 'match_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistiques_joueurs');
    }
};
