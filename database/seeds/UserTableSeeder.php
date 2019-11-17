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
        $admin = \App\User::create([
            'type'=>0,
            'active'=>true
        ]);
        $admin->user()->create([
            'name'=>'Admin',
            'username'=>'admin',
            'phone'=>'mahmoudnada5050@gmail.com',
            'email'=>'01208971865',
            'password'=>123456,
        ]);
    }
}
