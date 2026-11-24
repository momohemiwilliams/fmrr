<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    private array $permissions = [
        'subscription-tier-list',
        'subscription-tier-create',
        'subscription-tier-edit',
        'subscription-tier-delete',
        'subscription-tier-approve',
        'subscription-tier-reject',
    ];

    public function up(): void
    {
        foreach ($this->permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        }

        $roles = Role::whereIn('name', ['Portal Admin', 'Super Admin'])->get();
        foreach ($roles as $role) {
            $role->givePermissionTo($this->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        $roles = Role::whereIn('name', ['Portal Admin', 'Super Admin'])->get();
        foreach ($roles as $role) {
            $role->revokePermissionTo($this->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
