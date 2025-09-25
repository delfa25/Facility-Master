<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Seed two sample years; set the first as current
            AcademicYear::updateOrCreate(
                ['name' => '2024–2025'],
                [
                    'start_date' => '2024-10-01',
                    'end_date'   => '2025-06-30',
                    'is_current' => true,
                ]
            );

            AcademicYear::updateOrCreate(
                ['name' => '2025–2026'],
                [
                    'start_date' => '2025-10-01',
                    'end_date'   => '2026-06-30',
                    'is_current' => false,
                ]
            );

            // Ensure single current year
            $current = AcademicYear::where('is_current', true)->orderBy('start_date')->first();
            if ($current) {
                AcademicYear::where('id', '!=', $current->id)->update(['is_current' => false]);
            }
        });
    }
}
