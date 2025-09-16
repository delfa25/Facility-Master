<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materiel', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 150);
            $table->string('categorie', 100);
            $table->unsignedInteger('quantite');
            $table->string('etat', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materiel');
    }
};
