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
        Schema::create('groupe_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupe_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date_affectation')->nullable();
            $table->timestamps();
            
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe_student');
    }
};
