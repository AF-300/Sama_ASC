<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropForeign(['joueur_id']);
            $table->dropColumn('joueur_id');
            $table->foreignId('contributeur_id')->after('id')->constrained('contributeurs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropForeign(['contributeur_id']);
            $table->dropColumn('contributeur_id');
            $table->foreignId('joueur_id')->constrained('joueurs')->cascadeOnDelete();
        });
    }
};