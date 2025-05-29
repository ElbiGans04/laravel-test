<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pemilik = Role::create([
            "name" => "pemilik",
            "guard_name" => 'web',
        ]);

        $petugas = Role::create([
            "name" => "petugas",
            "guard_name" => 'web',
        ]);

        $admin = Role::create([
            "name" => "admin",
            "guard_name" => 'web',
        ]);

        $pemilik->givePermissionTo(Permission::all());
        $admin->givePermissionTo(
            [
                'book.create',
                'book.read',
                'book.update',
                'book.delete',
                'car.read'
            ]
        );
        $petugas->givePermissionTo([
            'car.create',
            'car.read',
            'car.update',
            'car.delete',
        ]);

        User::find(1)->assignRole($pemilik);
        User::find(2)->assignRole($admin);
        User::find(2)->assignRole($petugas);
    }
}
