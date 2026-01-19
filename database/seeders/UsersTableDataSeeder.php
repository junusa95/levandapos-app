<?php

namespace Database\Seeders;

use DB;
use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('roles')->delete();
        DB::table('users')->delete();

        // $roles = array(
        //     array('name' => 'Admin'),
        //     array('name' => 'Business Owner'),
        //     array('name' => 'CEO'),
        //     array('name' => 'Store Manager'),
        //     array('name' => 'Accountant'),
        //     array('name' => 'Cashier'),
        //     array('name' => 'Sales Person'),
        //     array('name' => 'Store Master'),
        //     array('name' => 'Shipper'),
        //     array('name' => 'Stock Approver'),
        // );
        // Role::insert($roles);

        $user = User::create([
            'name'=>'Admin', 
            'username'=>'admin', 
            'email'=>'admin@levanda.co.tz',
            'password'=>'$2y$10$yt/uZkrUK1qU8DoJs6AFCexBL6sU1lpuCkf9dbRtOrsLFtJBcjGQq', 
            'gender'=>'Male',
            'phonecode'=>'255',
            'phone'=>'659 992 590',
            'status'=>'active',
        ]);

        $user_roles = array(
            array('user_id' => $user->id, 'role_id'=>1),
            // array('user_id' => $user->id, 'role_id'=>2),
            // array('user_id' => $user->id, 'role_id'=>3),
            // array('user_id' => $user->id, 'role_id'=>4),
            // array('user_id' => $user->id, 'role_id'=>5),
            // array('user_id' => $user->id, 'role_id'=>6),
            // array('user_id' => $user->id, 'role_id'=>7),
            // array('user_id' => $user->id, 'role_id'=>8),
            // array('user_id' => $user->id, 'role_id'=>9),
            // array('user_id' => $user->id, 'role_id'=>10),
        );
        DB::table('user_roles')->insert($user_roles);
    }
}
