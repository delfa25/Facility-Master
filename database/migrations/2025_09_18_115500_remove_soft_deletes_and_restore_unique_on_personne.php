<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Revert unique constraint on personne.email and drop deleted_at columns
        Schema::table('personne', function (Blueprint $table) {
            // If composite unique (email, deleted_at) exists, drop it safely
            if (Schema::hasColumn('personne', 'deleted_at')) {
                // Try dropping by columns for portability
                try {
                    $table->dropUnique(['email', 'deleted_at']);
                } catch (\Throwable $e) {
                    // Fallback: try by the name used in prior migration if present
                    try { $table->dropUnique('personne_email_deleted_at_unique'); } catch (\Throwable $e2) {}
                }
            }

            // Ensure a unique index on email only
            try {
                $table->unique('email');
            } catch (\Throwable $e) {
                // ignore if already unique
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('personne', function (Blueprint $table) {
            if (Schema::hasColumn('personne', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }

    public function down(): void
    {
        // Re-add deleted_at columns and composite unique if rolling back
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('personne', function (Blueprint $table) {
            if (!Schema::hasColumn('personne', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('personne', function (Blueprint $table) {
            // Drop unique on email only
            try {
                $table->dropUnique(['email']);
            } catch (\Throwable $e) {
                // Sometimes index name is personne_email_unique
                try { $table->dropUnique('personne_email_unique'); } catch (\Throwable $e2) {}
            }

            // Recreate composite unique on (email, deleted_at)
            try {
                $table->unique(['email', 'deleted_at'], 'personne_email_deleted_at_unique');
            } catch (\Throwable $e) {}
        });
    }
};
