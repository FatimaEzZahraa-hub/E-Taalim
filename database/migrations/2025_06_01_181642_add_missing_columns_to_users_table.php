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
        Schema::table('users', function (Blueprint $table) {
            // Ajouter la colonne role si elle n'existe pas
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student')->after('password');
            }
            
            // Ajouter la colonne meta_data si elle n'existe pas
            if (!Schema::hasColumn('users', 'meta_data')) {
                $table->json('meta_data')->nullable()->after('role');
            }
            
            // Ajouter les colonnes niveau_id et groupe_id si elles n'existent pas
            if (!Schema::hasColumn('users', 'niveau_id')) {
                $table->unsignedBigInteger('niveau_id')->nullable()->after('meta_data');
            }
            
            if (!Schema::hasColumn('users', 'groupe_id')) {
                $table->unsignedBigInteger('groupe_id')->nullable()->after('niveau_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ne pas supprimer les colonnes dans la migration down pour éviter la perte de données
            // Si nécessaire, créer une migration séparée pour supprimer ces colonnes
        });
    }
};
