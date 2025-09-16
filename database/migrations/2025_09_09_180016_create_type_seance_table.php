<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('type_seance', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10); // CM|TD|TP|EXAM
            $table->string('libelle', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('type_seance');
    }
};
