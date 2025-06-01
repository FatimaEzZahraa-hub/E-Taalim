<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoumissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soumissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devoir_id')->constrained('devoirs')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');
            $table->text('commentaire')->nullable();
            $table->string('fichier')->nullable();
            $table->float('note')->nullable();
            $table->text('feedback_enseignant')->nullable();
            $table->dateTime('date_soumission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soumissions');
    }
}
