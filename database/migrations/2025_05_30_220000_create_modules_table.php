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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('code', 20)->nullable(); // Code du module (ex: MATH101)
            $table->string('image')->nullable(); // Image repru00e9sentative du module
            $table->string('couleur', 20)->nullable(); // Couleur pour l'affichage dans l'interface
            $table->foreignId('niveau_id')->constrained('niveaux');
            $table->foreignId('enseignant_id')->constrained('users');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        // Table pivot pour la relation many-to-many entre modules et groupes
        Schema::create('module_groupe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained()->onDelete('cascade');
            $table->date('date_affectation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_groupe');
        Schema::dropIfExists('modules');
    }
};
