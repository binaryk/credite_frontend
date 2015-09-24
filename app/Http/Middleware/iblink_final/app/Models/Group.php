<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    protected $fillable = ['name', 'master_id', 'year_id', 'num', 'letter'];

    protected static $roman = [
        1  => 'I',
        2  => 'II',
        3  => 'III',
        4  => 'IV',
        5  => 'V',
        6  => 'VI',
        7  => 'VII',
        8  => 'VIII',
        9  => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public function institution() {
        return $this->belongsTo('App\Models\Institution');
    }

    public function master() {
        return $this->belongsTo('App\Models\User');
    }

    public function subjects() {
        return $this->belongsToMany('App\Models\Subject', 'subject_teacher_group');
    }

    public function students() {
        return $this->belongsToMany('App\Models\Student');
    }

    public static function getRomanNumbers() {
        return self::$roman;
    }

    public function selfRename() {

        $nums  = self::getRomanNumbers();
        $roman = $nums[$this->num];

        $this->letter = strtoupper($this->letter);
        $this->name   = $roman . ' ' . strtoupper($this->letter);

        return $this;
    }

}
