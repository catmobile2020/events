<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'=>'Admin',
            'username'=>'admin',
            'email'=>'mahmoudnada5050@gmail.com',
            'phone'=>'01208971865',
            'type'=>0,
            'active'=>true,
            'password'=>bcrypt(123456),
        ]);
    }
}
