<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        
        // Insertion des rôles de base
        DB::table('role')->insert([
            ['nom' => 'administrateur', 'description' => 'Administrateur de la plateforme', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'enseignant', 'description' => 'Enseignant', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'etudiant', 'description' => 'Étudiant', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
