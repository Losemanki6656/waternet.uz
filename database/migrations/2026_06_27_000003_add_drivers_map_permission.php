<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'drivers-map', 'guard_name' => 'web']);
        User::permission('bosh-menu')->get()->each(function (User $user) use ($permission) {
            $user->givePermissionTo($permission);
        });
    }

    public function down(): void
    {
        Permission::where('name', 'drivers-map')->delete();
    }
};
