<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('joueurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('poste')->nullable(); // gardien, defenseur, milieu, attaquant
            $table->unsignedTinyInteger('numero_maillot')->nullable();
            $table->string('photo')->nullable();
            $table->string('quartier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('joueurs');
    }
};