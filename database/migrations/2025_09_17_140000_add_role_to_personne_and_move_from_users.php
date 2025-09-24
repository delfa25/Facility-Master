<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Option B: personne removed. Keep users.role as authoritative.
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT', 'INVITE'])->default('INVITE')->after('must_change_password');
            }
        });
    }

    public function down(): void
    {
        // No-op
    }
};
