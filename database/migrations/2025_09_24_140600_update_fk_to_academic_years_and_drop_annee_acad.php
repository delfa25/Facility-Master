<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update classe.annee_id FK
        Schema::table('classe', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('academic_years');
        });

        // Update inscription.annee_id FK
        Schema::table('inscription', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('academic_years');
        });

        // Update semestre.annee_id FK
        Schema::table('semestre', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('academic_years');
        });

        // Drop legacy annee_acad table if exists
        Schema::dropIfExists('annee_acad');
    }

    public function down(): void
    {
        // Recreate legacy table minimal if needed for rollback (without data)
        Schema::create('annee_acad', function (Blueprint $table) {
            $table->id();
            $table->string('annee')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });

        // Point back foreign keys to annee_acad
        Schema::table('classe', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('annee_acad');
        });
        Schema::table('inscription', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('annee_acad');
        });
        Schema::table('semestre', function (Blueprint $table) {
            try { $table->dropForeign(['annee_id']); } catch (\Throwable $e) {}
            $table->foreign('annee_id')->references('id')->on('annee_acad');
        });
    }
};
