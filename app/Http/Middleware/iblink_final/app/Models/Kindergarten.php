<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kindergarten extends Model {

    protected $morphClass = 'kindergarten';

    public function institution() {
        return $this->morphOne('App\Models\Institution', 'institutionable');
    }

    public function getName() {
        return 'Grădiniță';
    }

}
