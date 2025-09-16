<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant_groupe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiant');
            $table->foreignId('groupe_id')->constrained('groupe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant_groupe');
    }
};
