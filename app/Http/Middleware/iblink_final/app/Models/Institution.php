<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class Institution extends Model {

    protected $types = [
        'kindergarten' => 'App\Models\Kindergarten',
        'school'       => 'App\Models\School',
    ];

    protected $fillable = [
        'name', 'sirues', 'cycle', 'phone',
        'email', 'address', 'image', 'description',
        'city_id'
    ];

    protected static $mockedSemester = false;

    public $timestamps = false;

    public function getInstitutionableTypeAttribute($type) {
        return array_get($this->types, $type, $type);
    }

    public function institutionable() {
        return $this->morphTo();
    }

    public function users() {
        return $this->belongsToMany('App\Models\User')->orderBy('users.id','asc');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

    public function groups() {
        return $this->hasMany('App\Models\Group');
    }

    public function subjects() {
        return $this->hasMany('App\Models\Subject');
    }

    public function semester() {
        return $this->belongsTo('App\Models\Semester', 'active_semester_id');
    }

    public static function current() 
    {
        static $institution = false;
        if (!$institution) 
        {
            $institution = Institution::find(Session::get('institution.id'));
        }
        return $institution;
    }

    public function getActiveSemesterIdAttribute($value) {

        if (Session::has('mocked.semester')) {
            return Session::get('mocked.semester');
        }

        return $value;
    }

    public static function mock(Semester $semester) {
        Session::set('mocked.semester', $semester->id);
    }

    public static function removeMock() {
        Session::remove('mocked.semester');
    }

}
