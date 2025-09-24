<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseignant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('grade', 50)->nullable();
            $table->string('specialite', 100)->nullable();
            $table->enum('statut', ['INACTIF','SUSPENDU','ACTIF'])->default('INACTIF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignant');
    }
};
