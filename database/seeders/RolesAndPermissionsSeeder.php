<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'user.view','user.create','user.update','user.delete',
            'etudiant.view','etudiant.create','etudiant.update','etudiant.delete',
            'enseignant.view','enseignant.create','enseignant.update','enseignant.delete',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $roles = [
            'ETUDIANT' => ['etudiant.view'],
            'ENSEIGNANT' => ['enseignant.view'],
            'ADMINISTRATEUR' => $permissions,
            'SUPERADMIN' => $permissions,
            'INVITE' => [],
        ];

        foreach ($roles as $role => $perms) {
            $r = Role::firstOrCreate(['name' => $role]);
            $r->syncPermissions($perms);
        }
    }
}
