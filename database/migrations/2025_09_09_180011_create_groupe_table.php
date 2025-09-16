<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groupe', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30); // TD1|TPA|CM
            $table->enum('type', ['CM','TD','TP','Projet']);
            $table->foreignId('classe_id')->constrained('classe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groupe');
    }
};
