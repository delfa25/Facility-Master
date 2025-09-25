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

        // Declare permissions per resource (view/create/update/delete)
        $resources = [
            'user', 'etudiant', 'enseignant', 'filiere', 'academic_year', 'niveau', 'semestre', 'salle', 'typeseance', 'classe', 'cycle', 'inscription', 'role', 'permission',
        ];

        $permissions = [];
        foreach ($resources as $res) {
            $permissions[] = "$res.view";
            $permissions[] = "$res.create";
            $permissions[] = "$res.update";
            $permissions[] = "$res.delete";
        }

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $roles = [
            'ETUDIANT' => ['etudiant.view'],
            'ENSEIGNANT' => ['enseignant.view'],
            // ADMINISTRATEUR: grant broad management but not security (role/permission)
            'ADMINISTRATEUR' => collect($permissions)
                ->reject(fn($p) => str_starts_with($p, 'role.') || str_starts_with($p, 'permission.'))
                ->values()
                ->all(),
            // SUPERADMIN: all existing permissions
            'SUPERADMIN' => Permission::pluck('name')->all(),
            'INVITE' => [],
        ];

        foreach ($roles as $role => $perms) {
            $r = Role::firstOrCreate(['name' => $role]);
            $r->syncPermissions($perms);
        }
    }
}
