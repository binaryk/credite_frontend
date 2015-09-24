<?php

use Illuminate\Database\Seeder;

class YearSeeder extends Seeder {

    public function run() {

        $this->command->info('Creating years and semesters');

        DB::table('years')->insert([
            ['id' => 1, 'name' => '2015 - 2016'],
            ['id' => 2, 'name' => '2016 - 2017'],
        ]);

        DB::table('semesters')->insert([
            ['id' => 1, 'year_id' => 1, 'start' => '2015-09-14', 'end' => '2016-01-29', 'name' => 'I'],
            ['id' => 2, 'year_id' => 1, 'start' => '2016-02-08', 'end' => '2016-06-17', 'name' => 'II'],
            ['id' => 3, 'year_id' => 2, 'start' => '2016-09-14', 'end' => '2017-01-29', 'name' => 'I'],
            ['id' => 4, 'year_id' => 2, 'start' => '2017-02-08', 'end' => '2017-06-17', 'name' => 'II'],
        ]);

        DB::table('institutions')->update([
            'active_semester_id' => 1,
        ]);

        DB::table('groups')->update([
            'year_id' => 1,
        ]);
    }
}
