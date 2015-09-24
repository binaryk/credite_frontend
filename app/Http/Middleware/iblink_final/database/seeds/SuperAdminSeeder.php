<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder {

    public function run() {

        $this->command->info('Creating super-administrative users');

        DB::table('super_administrators')->insert([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ]);

        DB::table('users')->insert([
            ['id' => 1, 'email' => 'me@shark0der.com', 'name' => 'Anatol', 'password' => Hash::make('password'), 'userable_type' => 'superadmin', 'userable_id' => 1],
            ['id' => 2, 'email' => 'lucian@iblink.ro', 'name' => 'Lucian', 'password' => Hash::make('password'), 'userable_type' => 'superadmin', 'userable_id' => 2],
            ['id' => 3, 'email' => 'silvia@iblink.ro', 'name' => 'Silvia', 'password' => Hash::make('password'), 'userable_type' => 'superadmin', 'userable_id' => 3],
        ]);
    }
}
