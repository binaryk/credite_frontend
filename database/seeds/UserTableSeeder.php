<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	public function run()
	{

		User::create([
			'id' => '1',
			'fname' => 'Admin',
			'lname' => 'utilizator',
			'email' => 'admin@admin.com',
			'password' => bcrypt('admin'),
			'confirmed' => 1,
            'admin' => 1,
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);

		User::create([
			'id' => '2',
			'fname' => 'Utilizator',
			'lname' => 'simplu',
			'email' => 'user@user.com',
			'password' => bcrypt('user'),
			'confirmed' => 1,
			'confirmation_code' => md5(microtime() . env('APP_KEY')),
		]);

	}

}
