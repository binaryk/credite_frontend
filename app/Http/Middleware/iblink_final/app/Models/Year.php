<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model {

    public function semesters() {
        return $this->hasMany('\App\Models\Semester');
    }

    public function groups() {
        return $this->hasMany('\App\Models\Group');
    }

}
