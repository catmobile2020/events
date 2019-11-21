<?php

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
        $permissionArray = [
            [
                'name'=>'sponsors',
            ],[
                'name'=>'partnerships',
            ],[
                'name'=>'speakers',
            ],[
                'name'=>'talks',
            ],[
                'name'=>'posts',
            ],[
                'name'=>'feedback',
            ],[
                'name'=>'testimonials',
            ],[
                'name'=>'tickets',
            ],[
                'name'=>'chat group',
            ],[
                'name'=>'live questions',
            ],[
                'name'=>'live poll',
            ]
        ];
          foreach ($permissionArray as $permission)
          {
              Permission::create($permission);
          }
//        $user->givePermissionTo(['edit articles', 'delete articles']);

    }
}
