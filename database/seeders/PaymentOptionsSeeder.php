<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = '[{"id":1,"name":"Cash","created_at":"2025-10-05 20:26:51","updated_at":"2025-10-05 20:26:51"},{"id":2,"name":"Mobile Money","created_at":"2025-10-05 20:27:10","updated_at":"2025-10-05 20:27:10"},{"id":3,"name":"Bank","created_at":"2025-10-05 20:27:21","updated_at":"2025-10-05 20:27:21"}]';

        $records = json_decode($array, true);    

        DB::table('payment_options')->insert($records);

    }
}
