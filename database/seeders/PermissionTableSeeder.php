<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'admin',
           'bosh-menu',
           'clients',
           'orders',
           'regions',
           'sklad',
           'smsmanager',
           'results',
           'products',
           'users',
           'per-delete',
           'director',
           'driver',
           'operator',
           'warehouse',
           'manager'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}