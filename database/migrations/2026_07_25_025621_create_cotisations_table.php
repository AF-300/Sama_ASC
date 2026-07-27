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
    Schema::create('cotisations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('joueur_id')->constrained('joueurs')->cascadeOnDelete();
        $table->decimal('montant', 10, 2);
        $table->date('date_paiement')->nullable();
        $table->string('periode'); // ex: "2026-07"
        $table->enum('statut', ['paye', 'en_attente', 'en_retard'])->default('en_attente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
