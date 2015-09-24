<?php

use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder {

    public function run() {

        $this->command->info('Creating institutions');

        DB::table('kindergartens')->insert([
            ['id' => 1],
        ]);

        DB::table('schools')->insert([
            ['id' => 1],
        ]);

        DB::table('institutions')->insert([
            [
                'id'                   => 1,
                'institutionable_id'   => 1,
                'institutionable_type' => 'school',
                'name'                 => 'International School of Bucharest',
                'sirues'               => '12345',
                'cycle'                => 'Primar',
                'phone'                => '(+40) 21 306 95 30',
                'email'                => 'info@isb.ro',
                'address'              => 'Sos Gara Catelu, Nr. 1R, Sector 3, 032991, Bucharest, Romania',
                'image'                => '/assets/img/isb.jpg',
                'description'          => 'International School of Bucharest',
                'city_id'              => 2715,
            ],
            [
                'id'                   => 2,
                'institutionable_id'   => 1,
                'institutionable_type' => 'kindergarten',
                'name'                 => 'Grădinița Spectrum',
                'sirues'               => '12345',
                'cycle'                => 'Preșcolar',
                'phone'                => '(+40) 21 327 15 41',
                'email'                => 'gradinita@spectrum.ro',
                'address'              => 'Str. Energeticienilor, Nr. 9-11, Sector 3',
                'image'                => '/assets/img/spectrum.png',
                'description'          => 'Grădinița Spectrum',
                'city_id'              => 2715,
            ],
        ]);
    }
}
