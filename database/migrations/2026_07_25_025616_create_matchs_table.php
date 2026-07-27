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
    Schema::create('matchs', function (Blueprint $table) {
        $table->id();
        $table->string('adversaire');
        $table->date('date_match');
        $table->time('heure')->nullable();
        $table->string('lieu')->nullable();
        $table->unsignedTinyInteger('score_asc')->nullable();
        $table->unsignedTinyInteger('score_adversaire')->nullable();
        $table->enum('statut', ['a_venir', 'joue', 'annule'])->default('a_venir');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchs');
    }
};
