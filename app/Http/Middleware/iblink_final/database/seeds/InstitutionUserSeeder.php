<?php

use Illuminate\Database\Seeder;

class InstitutionUserSeeder extends Seeder {

    public function run() {

        $this->command->info('Assigning institutions to users');

        DB::table('institution_user')->insert([
            ['institution_id' => 1, 'user_id' => 1],
            ['institution_id' => 2, 'user_id' => 1],
            ['institution_id' => 1, 'user_id' => 2],
            ['institution_id' => 2, 'user_id' => 2],
            ['institution_id' => 1, 'user_id' => 3],
            ['institution_id' => 2, 'user_id' => 3],
        ]);
    }
}
