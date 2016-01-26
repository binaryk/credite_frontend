<?php

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder {

    public function run()
    {
        Destination::truncate();
        Destination::insert([
            [ 'id' => '1', 'from'=> 'Norwich', 'to' => 'Tilbury', 'price' => '115', 'type' => 'port' ],
            [ 'id' => '2', 'from'=> 'Norwich', 'to' => 'Harwich', 'price' => '80', 'type' => 'port' ],
            [ 'id' => '3', 'from'=> 'Norwich', 'to' => 'Portsmouth', 'price' => '220', 'type' => 'port' ],
            [ 'id' => '4', 'from'=> 'Norwich', 'to' => 'Dover', 'price' => '190', 'type' => 'port' ],
            [ 'id' => '5', 'from'=> 'Norwich', 'to' => 'Southhampton', 'price' => '220', 'type' => 'port' ],
            ['id' => '6', 'from' => 'Norwich', 'to' =>'Stansted', 'price' => '85', 'type' => 'airport' ],
            ['id' => '7', 'from' => 'Norwich', 'to' =>'Luton', 'price' => '105', 'type' => 'airport' ],
            ['id' => '8', 'from' => 'Norwich', 'to' =>'Gatwick', 'price' => '155', 'type' => 'airport' ],
            ['id' => '9', 'from' => 'Norwich', 'to' =>'Heathrow', 'price' => '155', 'type' => 'airport' ],
            ['id' => '10', 'from' => 'Norwich', 'to' =>'London city airport', 'price' => '150', 'type' => 'airport' ],
            ['id' => '11', 'from' => 'Norwich', 'to' =>'London south end airport', 'price' => '105', 'type' => 'airport' ],
            ['id' => '12', 'from' => 'Norwich', 'to' =>'Biggin hill airport', 'price' => '140', 'type' => 'airport' ],
            ['id' => '13', 'from' => 'Norwich', 'to' =>'Birmingham', 'price' => '160', 'type' => 'airport' ],
            ['id' => '14', 'from' => 'Norwich', 'to' =>'Bristol', 'price' => '270', 'type' => 'airport' ],
            ['id' => '15', 'from' => 'Norwich', 'to' =>'Cardiff', 'price' => '310', 'type' => 'airport' ],
            ['id' => '16', 'from' => 'Norwich', 'to' =>'Liverpool', 'price' => '270', 'type' => 'airport' ],
            ['id' => '17', 'from' => 'Norwich', 'to' =>'Manchester', 'price' => '215', 'type' => 'airport' ],
        ]);

    }
}
