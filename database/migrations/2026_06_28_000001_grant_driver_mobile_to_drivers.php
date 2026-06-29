<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'DriverMobile', 'guard_name' => 'web']);

        // Permissions are attached directly to users in this app. Grant the
        // DriverMobile permission to every driver (users.role == 3) so they can
        // log into the mobile app.
        User::where('role', 3)->get()->each(function (User $user) use ($permission) {
            $user->givePermissionTo($permission);
        });
    }

    public function down(): void
    {
        // Keep the permission itself; just revoke it from drivers.
        $permission = Permission::where('name', 'DriverMobile')->first();

        if ($permission) {
            User::where('role', 3)->get()->each(function (User $user) use ($permission) {
                $user->revokePermissionTo($permission);
            });
        }
    }
};
