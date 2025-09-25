<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up any orphaned records first (in case FKs were missing previously)
        DB::statement('DELETE FROM etudiant WHERE user_id NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM enseignant WHERE user_id NOT IN (SELECT id FROM users)');

        // Ensure etudiant.user_id cascades on delete
        Schema::table('etudiant', function (Blueprint $table) {
            // Drop existing foreign key if present
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // ignore if FK does not exist
            }
        });
        Schema::table('etudiant', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Ensure enseignant.user_id cascades on delete
        Schema::table('enseignant', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // ignore if FK does not exist
            }
        });
        Schema::table('enseignant', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Revert to non-cascading foreign keys (restrict on delete)
        Schema::table('etudiant', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {}
        });
        Schema::table('etudiant', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('enseignant', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {}
        });
        Schema::table('enseignant', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
