<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seance_exception', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_id')->constrained('seance')->cascadeOnDelete();
            $table->date('date_originale');
            $table->enum('action', ['ANNULATION','REPORT','MODIFICATION']);
            $table->date('date_report')->nullable();
            $table->foreignId('salle_id')->nullable()->constrained('salle');
            $table->foreignId('plage_id')->nullable()->constrained('plage_horaire');
            $table->text('motif')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seance_exception');
    }
};
