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
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student')->after('email');
            $table->unsignedBigInteger('niveau_id')->nullable()->after('role');
            $table->unsignedBigInteger('groupe_id')->nullable()->after('niveau_id');
            
            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('set null');
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['niveau_id']);
            $table->dropForeign(['groupe_id']);
            $table->dropColumn(['role', 'niveau_id', 'groupe_id']);
        });
    }
};
