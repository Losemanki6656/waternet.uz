<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'drivers-map', 'guard_name' => 'web']);

        // Grant it to every role that already has dashboard ("bosh-menu") access
        // (directors / admins), so the new menu shows up for them out of the box.
        Role::whereHas('permissions', function ($q) {
            $q->where('name', 'bosh-menu');
        })->get()->each(function (Role $role) use ($permission) {
            $role->givePermissionTo($permission);
        });
    }

    public function down(): void
    {
        Permission::where('name', 'drivers-map')->delete();
    }
};
