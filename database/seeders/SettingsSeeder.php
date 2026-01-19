<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = '[{"id":1,"name":"Expire date","description":"Add expire date to products","created_at":"2024-09-26 22:48:38","updated_at":"2024-09-26 22:48:38"},{"id":2,"name":"Minimum stock level","description":"Be alerted when stock reach a certain level","created_at":"2024-11-02 19:51:24","updated_at":"2024-11-02 19:51:24"},{"id":3,"name":"Sale Empty Stock","description":"Allow to sell products even if the quantities are not enough","created_at":"2024-11-13 21:58:52","updated_at":"2024-11-13 21:58:52"},{"id":4,"name":"Sales for previous dates","description":"Record sales for previous dates, limit no of days back to record sales","created_at":"2024-11-25 08:22:29","updated_at":"2024-11-25 08:22:29"},{"id":5,"name":"Import Products","description":"Import \/ Upload products in bulk","created_at":"2024-12-19 09:58:29","updated_at":"2024-12-19 09:58:29"}]';

        $records = json_decode($array, true);    

        DB::table('settings')->insert($records);

    }
}
