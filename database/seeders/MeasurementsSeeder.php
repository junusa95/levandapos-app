<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasurementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // this has to be updated first... skip seeding it for now 

        $array = '';

        $records = json_decode($array, true);    

        DB::table('measurements')->insert($records);

    }
}
