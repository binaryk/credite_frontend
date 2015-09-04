<?php

use Illuminate\Database\Seeder;

class AirportsTableSeeder extends Seeder {

	public function run()
	{

		\App\Models\Airport::insert([
			['id' => '1','name' => 'Heathrow Terminal 1 TW6 1JS'],
			['id' => '2','name' => 'Heathrow Terminal 2 TW6 1JS'],
			['id' => '3','name' => 'Heathrow Terminal 3 TW6 1JS'],
			['id' => '4','name' => 'Heathrow Terminal 4 TW6 2GA'],
			['id' => '5','name' => 'Heathrow Terminal 5 TW7 2GA'],
			['id' => '6','name' => 'GATWICK AIRPORT NORTH RH6 0PJ'],
			['id' => '7','name' => 'GATWICK SOUTH RH6 0PJ'],
			['id' => '8','name' => 'LUTON AIRPORT LU2 9LY'],
			['id' => '9','name' => 'Stansted Airport CM24 1QW'],
			['id' => '10','name' => 'LONDON CITY AIRPORT E16 2PB'],
			['id' => '11','name' => 'Biggin Hill Airport TN16 3BN'],
			['id' => '12','name' => 'Birmingham Airport B26 3QJ'],
			['id' => '13','name' => 'Bristol Airport BS48 3DY'],
			['id' => '14','name' => 'Cardiff Airport CF62 3BD'],
			['id' => '15','name' => 'Liverpool Airport L24 1YD'],
			['id' => '16','name' => 'Manchester Airport M90 1QX'],
		]);

	}
} 
