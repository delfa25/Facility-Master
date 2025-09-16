<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignement_id')->constrained('enseignement');
            $table->foreignId('salle_id')->constrained('salle');
            $table->foreignId('plage_id')->constrained('plage_horaire');
            $table->foreignId('type_seance_id')->constrained('type_seance');
            $table->date('date_exception')->nullable();
            $table->date('debut_periode')->nullable();
            $table->date('fin_periode')->nullable();
            $table->enum('recurrence', ['NONE','WEEKLY','BIWEEKLY'])->default('NONE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seance');
    }
};
