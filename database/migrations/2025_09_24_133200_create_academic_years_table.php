<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. "2024–2025"
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        // Optional DB-level helpers (not fully enforcing overlap across all RDBMS)
        // Ensure start_date < end_date at DB level where supported
        try {
            DB::statement("ALTER TABLE academic_years ADD CONSTRAINT chk_academic_year_dates CHECK (start_date < end_date)");
        } catch (\Throwable $e) {
            // Some DB engines (like older MySQL) may not support CHECK; app-layer validation will enforce
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
