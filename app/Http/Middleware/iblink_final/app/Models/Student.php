<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    protected $fillable = [
        'group_id', 'lastname', 'parents_initials', 'firstname', 'gender',
        'dob', 'cnp', 'nationality', 'emergency_name', 'emergency_phone',
        'secondary_emergency_name', 'secondary_emergency_phone', 'image',
    ];

    public $timestamps = false;

    protected static $genders = ['male' => 'Masculin', 'female' => 'Feminin'];

    public static function getStaticMorphClass() {
        return 'student';
    }

    public function __construct(array $attributes = []) {
        $this->morphClass = self::getStaticMorphClass();
        parent::__construct($attributes);
    }

    public function user() {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function getRoleTitle() {
        return 'Elev';
    }

    public function groups() {
        return $this->belongsToMany('App\Models\Group');
    }

    public function custodians() {
        return $this->user->belongsToMany('App\Models\User', 'custodian_students', 'student_id', 'custodian_id');
    }

    public static function getGenders() {
        return self::$genders;
    }

    public function grades() {
        return $this->hasMany('\App\Models\Grade');
    }

    public static function getGender($gender) {

        switch ($gender) {
            case 'male':
                return 'Masculin';
            case 'female':
                return 'Feminin';
        }

        throw new \Exception('Invalid gender provided');
    }

}