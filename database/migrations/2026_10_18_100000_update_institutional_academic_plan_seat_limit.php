<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // 1. Ensure Institutional Academic Subscription Annual has seat_limit = 6 (1 owner + 5 additional members)
        DB::table('subscription_plans')
            ->where('name', 'like', '%Institutional Academic%')
            ->update(['seat_limit' => 6]);

        // 2. Ensure student verification permissions are created and assigned to Portal Admin and Super Admin
        $permissions = [
            'student-verification-list',
            'student-verification-approve',
            'student-verification-reject',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        }

        $roles = Role::whereIn('name', ['Portal Admin', 'Super Admin'])->get();
        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }

        if (class_exists(\Spatie\Permission\PermissionRegistrar::class)) {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // No down migration needed
    }
};
