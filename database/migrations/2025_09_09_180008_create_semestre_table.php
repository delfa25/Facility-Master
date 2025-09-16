<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semestre', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignId('annee_id')->constrained('annee_acad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semestre');
    }
};
