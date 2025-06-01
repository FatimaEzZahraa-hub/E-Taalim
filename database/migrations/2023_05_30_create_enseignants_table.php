<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_utilisateur');
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->nullable();
            $table->string('specialite');
            $table->string('grade');
            $table->text('bio')->nullable();
            $table->timestamps();
            
            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignants');
    }
}
