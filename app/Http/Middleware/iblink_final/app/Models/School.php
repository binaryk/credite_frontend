<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    protected $morphClass = 'school';

    public function institution() {
        return $this->morphOne('App\Models\Institution', 'institutionable');
    }

    public function getName() {
        return 'Școală';
    }

}
