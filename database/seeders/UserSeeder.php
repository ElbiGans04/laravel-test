<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Rhafael';
        $user->email = 'rhafael@gmail.com';
        $user->password = Hash::make('test1234');
        $user->save();

        // 2
        $user2 = new User();
        $user2->name = 'Admin';
        $user2->email = 'admin@gmail.com';
        $user2->password = Hash::make('test1234');
        $user2->save();

        // 3
        $user3 = new User();
        $user3->name = 'petugas';
        $user3->email = 'petugas@gmail.com';
        $user3->password = Hash::make('test1234');
        $user3->save();
    }
}
