<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personne', function (Blueprint $table) {
            if (!Schema::hasColumn('personne', 'role')) {
                $table->enum('role', ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT', 'INVITE'])->default('INVITE')->after('phone');
            }
        });

        // Migrate data from users.role to personne.role when possible
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            DB::statement("UPDATE personne p JOIN users u ON u.personne_id = p.id SET p.role = u.role WHERE u.role IS NOT NULL");
        }

        // Drop users.role as it's now sourced from personne
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }

    public function down(): void
    {
        // Recreate users.role
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT', 'INVITE'])->default('INVITE')->after('must_change_password');
            }
        });

        // Migrate data back from personne.role to users.role
        if (Schema::hasTable('personne') && Schema::hasColumn('personne', 'role')) {
            DB::statement("UPDATE users u JOIN personne p ON u.personne_id = p.id SET u.role = p.role WHERE p.role IS NOT NULL");
        }

        // Drop personne.role
        Schema::table('personne', function (Blueprint $table) {
            if (Schema::hasColumn('personne', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
