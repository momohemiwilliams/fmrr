<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    private array $permissions = [
        'student-verification-list',
        'student-verification-approve',
        'student-verification-reject',
    ];

    public function up(): void
    {
        foreach ($this->permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        }

        $role = Role::where('name', 'Portal Admin')->where('guard_name', 'web')->first();
        if ($role) {
            $role->givePermissionTo($this->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        $role = Role::where('name', 'Portal Admin')->where('guard_name', 'web')->first();
        if ($role) {
            $role->revokePermissionTo($this->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
