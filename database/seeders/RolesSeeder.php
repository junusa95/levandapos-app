<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = '[{"id":1,"name":"Admin","created_at":null,"updated_at":null},{"id":2,"name":"Business Owner","created_at":null,"updated_at":null},{"id":3,"name":"CEO","created_at":null,"updated_at":null},{"id":4,"name":"Store Manager","created_at":null,"updated_at":null},{"id":5,"name":"Accountant","created_at":null,"updated_at":null},{"id":6,"name":"Cashier","created_at":null,"updated_at":null},{"id":7,"name":"Sales Person","created_at":null,"updated_at":null},{"id":8,"name":"Store Master","created_at":null,"updated_at":null},{"id":9,"name":"Shipper","created_at":null,"updated_at":null},{"id":10,"name":"Stock Approver","created_at":null,"updated_at":null},{"id":11,"name":"Agent","created_at":null,"updated_at":null}]';

        $records = json_decode($array, true);    

        DB::table('roles')->insert($records);

    }
}
