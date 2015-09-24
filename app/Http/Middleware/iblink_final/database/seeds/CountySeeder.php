<?php

use Illuminate\Database\Seeder;

class CountySeeder extends Seeder {

    public function run() {

        $this->command->info('Populating counties table');

        DB::table('counties')->insert([
            ['id' => '1', 'code' => 'DJ', 'name' => 'Dolj'],
            ['id' => '2', 'code' => 'BC', 'name' => 'Bacău'],
            ['id' => '3', 'code' => 'HR', 'name' => 'Harghita'],
            ['id' => '4', 'code' => 'BN', 'name' => 'Bistrița-Năsăud'],
            ['id' => '5', 'code' => 'DB', 'name' => 'Dâmbovița'],
            ['id' => '6', 'code' => 'SV', 'name' => 'Suceava'],
            ['id' => '7', 'code' => 'BT', 'name' => 'Botoșani'],
            ['id' => '8', 'code' => 'BV', 'name' => 'Brașov'],
            ['id' => '9', 'code' => 'B', 'name' => 'București'],
            ['id' => '10', 'code' => 'BR', 'name' => 'Brăila'],
            ['id' => '11', 'code' => 'HD', 'name' => 'Hunedoara'],
            ['id' => '12', 'code' => 'TR', 'name' => 'Teleorman'],
            ['id' => '13', 'code' => 'CV', 'name' => 'Covasna'],
            ['id' => '14', 'code' => 'TL', 'name' => 'Tulcea'],
            ['id' => '15', 'code' => 'TM', 'name' => 'Timiș'],
            ['id' => '16', 'code' => 'BZ', 'name' => 'Buzău'],
            ['id' => '17', 'code' => 'PH', 'name' => 'Prahova'],
            ['id' => '18', 'code' => 'IF', 'name' => 'Ilfov'],
            ['id' => '19', 'code' => 'NT', 'name' => 'Neamț'],
            ['id' => '20', 'code' => 'CJ', 'name' => 'Cluj'],
            ['id' => '21', 'code' => 'AB', 'name' => 'Alba'],
            ['id' => '22', 'code' => 'GR', 'name' => 'Giurgiu'],
            ['id' => '23', 'code' => 'AG', 'name' => 'Argeș'],
            ['id' => '24', 'code' => 'CL', 'name' => 'Călărași'],
            ['id' => '25', 'code' => 'BH', 'name' => 'Bihor'],
            ['id' => '26', 'code' => 'IS', 'name' => 'Iași'],
            ['id' => '27', 'code' => 'VL', 'name' => 'Vâlcea'],
            ['id' => '28', 'code' => 'VN', 'name' => 'Vrancea'],
            ['id' => '29', 'code' => 'AR', 'name' => 'Arad'],
            ['id' => '30', 'code' => 'IL', 'name' => 'Ialomița'],
            ['id' => '31', 'code' => 'CS', 'name' => 'Caraș-Severin'],
            ['id' => '32', 'code' => 'GL', 'name' => 'Galați'],
            ['id' => '33', 'code' => 'GJ', 'name' => 'Gorj'],
            ['id' => '34', 'code' => 'CT', 'name' => 'Constanța'],
            ['id' => '35', 'code' => 'SM', 'name' => 'Satu Mare'],
            ['id' => '36', 'code' => 'MM', 'name' => 'Maramureș'],
            ['id' => '37', 'code' => 'MH', 'name' => 'Mehedinți'],
            ['id' => '38', 'code' => 'SJ', 'name' => 'Sălaj'],
            ['id' => '39', 'code' => 'VS', 'name' => 'Vaslui'],
            ['id' => '40', 'code' => 'MS', 'name' => 'Mureș'],
            ['id' => '41', 'code' => 'SB', 'name' => 'Sibiu'],
            ['id' => '42', 'code' => 'OT', 'name' => 'Olt'],
        ]);
    }
}
