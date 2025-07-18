<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Super Admin', 'Admin', 'User'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        Artisan::call('permission:sync-gates');

        // Contoh permission (boleh ditambah ikut keperluan)
        // $permissions = ['create task', 'edit task', 'delete task'];

        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }

        // Assign semua permission ke Super Admin
        Role::where('name', 'Super Admin')->first()
            ->givePermissionTo(Permission::all());
    }
}
