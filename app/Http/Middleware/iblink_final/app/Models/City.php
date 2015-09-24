<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

    public function county() {
        return $this->belongsTo('App\Models\County');
    }

    public function institutions() {
        return $this->hasMany('\App\Models\Institution');
    }

}
