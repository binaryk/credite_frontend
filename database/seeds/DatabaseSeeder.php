<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Add calls to Seeders here
         $this->call(UserTableSeeder::class);
         $this->call(LanguageTableSeeder::class);
		$this->call(DestinationsTableSeeder::class);

        Model::reguard();
    }
}
