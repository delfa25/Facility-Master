<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personne', function (Blueprint $table) {
            // Drop existing unique index on email only (portable across index name differences)
            $table->dropUnique(['email']);

            // Add a composite unique on (email, deleted_at) so soft-deleted rows don't block reuse
            $table->unique(['email', 'deleted_at'], 'personne_email_deleted_at_unique');
        });
    }

    public function down(): void
    {
        Schema::table('personne', function (Blueprint $table) {
            // Drop the composite unique using columns for portability
            $table->dropUnique(['email', 'deleted_at']);

            // Recreate the original unique on email only
            $table->unique('email');
        });
    }
};
