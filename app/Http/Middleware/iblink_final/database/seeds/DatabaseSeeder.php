<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call('CountySeeder');
        $this->call('CitySeeder');
        $this->call('CountrySeeder');
        $this->call('SuperAdminSeeder');
        $this->call('InstitutionSeeder');
        $this->call('InstitutionUserSeeder');
        $this->call('YearSeeder');
    }
}
