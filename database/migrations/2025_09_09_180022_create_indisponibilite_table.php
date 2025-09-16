<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indisponibilite', function (Blueprint $table) {
            $table->id();
            $table->enum('ressource_type', ['ENSEIGNANT','SALLE']);
            $table->unsignedBigInteger('ressource_id');
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->string('motif', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indisponibilite');
    }
};
