<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create([
            "name" => "users.create",
        ]);
        Permission::create([
            "name" => "users.read",
        ]);
        Permission::create([
            "name" => "users.update",
        ]);
        Permission::create([
            "name" => "users.delete",
        ]);
        // Permissions
        Permission::create([
            "name" => "permissions.create",
        ]);
        Permission::create([
            "name" => "permissions.read",
        ]);
        Permission::create([
            "name" => "permissions.update",
        ]);
        Permission::create([
            "name" => "permissions.delete",
        ]);
        // Roles
        Permission::create([
            "name" => "roles.create",
        ]);
        Permission::create([
            "name" => "roles.read",
        ]);
        Permission::create([
            "name" => "roles.update",
        ]);
        Permission::create([
            "name" => "roles.delete",
        ]);
        // Book
        Permission::create([
            "name" => "book.create",
        ]);
        Permission::create([
            "name" => "book.read",
        ]);
        Permission::create([
            "name" => "book.update",
        ]);
        Permission::create([
            "name" => "book.delete",
        ]);
        // Car
        Permission::create([
            "name" => "car.create",
        ]);
        Permission::create([
            "name" => "car.read",
        ]);
        Permission::create([
            "name" => "car.update",
        ]);
        Permission::create([
            "name" => "car.delete",
        ]);

    }
}
