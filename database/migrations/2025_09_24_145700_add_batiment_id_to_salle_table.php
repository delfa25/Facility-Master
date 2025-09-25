<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salle', function (Blueprint $table) {
            $table->foreignId('batiment_id')->nullable()->after('localisation')->constrained('batiment');
        });
    }

    public function down(): void
    {
        Schema::table('salle', function (Blueprint $table) {
            $table->dropConstrainedForeignId('batiment_id');
        });
    }
};
