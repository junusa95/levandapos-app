<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = '[{"id":1,"name":"Tanzania Shilling","code":"TZS","status":null,"created_by":1,"created_at":"2023-03-12 00:46:20","updated_at":"2023-03-12 00:46:20"},{"id":2,"name":"US Dollar","code":"USD","status":null,"created_by":1,"created_at":"2023-03-12 00:50:21","updated_at":"2023-03-12 00:50:21"}]';

        $records = json_decode($array, true);    

        DB::table('currencies')->insert($records);

    }
}
