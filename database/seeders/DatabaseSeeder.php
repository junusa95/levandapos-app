<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $this->call(CurrenciesSeeder::class);
        $this->call(CountriesTableDataSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(WardsSeeder::class);
        $this->call(PaymentOptionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(SettingsSeeder::class);

        $this->call(UsersTableDataSeeder::class);
    }
}
