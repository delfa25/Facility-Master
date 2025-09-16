<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edt_publication', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classe');
            $table->foreignId('annee_id')->constrained('annee_acad');
            $table->unsignedInteger('version')->default(1);
            $table->enum('statut', ['BROUILLON','PUBLIE','ARCHIVE'])->default('BROUILLON');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('publie_par')->nullable()->constrained('users');
            $table->string('export_pdf', 255)->nullable();
            $table->string('export_ics', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edt_publication');
    }
};
