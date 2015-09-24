<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custodian extends Model {

    protected $fillable = [
        'lastname', 'firstname', 'phone', 'image'
    ];

    public $timestamps = false;

    public static function getStaticMorphClass() {
        return 'custodian';
    }

    public function __construct(array $attributes = []) {
        $this->morphClass = self::getStaticMorphClass();
        parent::__construct($attributes);
    }

    public function user() {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function getRoleTitle() {
        return 'Părinte';
    }

    public function students() {
        return $this->user->belongsToMany('\App\Models\User', 'custodian_students', 'custodian_id', 'student_id');
    }

}
