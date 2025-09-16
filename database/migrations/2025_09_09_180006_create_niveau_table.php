<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niveau', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->enum('libelle', ['L1','L2','L3','M1','M2']);
            $table->unsignedTinyInteger('ordre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveau');
    }
};
