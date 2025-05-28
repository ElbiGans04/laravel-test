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
    }
}
