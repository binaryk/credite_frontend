<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {

    protected $fillable = ['name', 'institution_id', 'type','teacher_id', 'grading_system'];
    protected static $types = ['mandatory', 'facultative', 'optional'];
    protected static $gradingSystems = ['grades', 'qualificatives'];

    public function institution() {
        return $this->belongsTo('App\Models\Institution');
    }

    public function master() {
        return $this->belongsTo('App\Models\User');
    }

    public function groups() {
        return $this->belongsToMany('App\Models\Subject', 'subject_teacher_group');
    }

    public function setTypeAttribute($value) {

        $value = strtolower($value);

        if (in_array($value, self::$types)) {
            $this->attributes['type'] = $value;

            return;
        }

        throw new \Exception('Invalid type value: ' . $value);
    }

    public static function getTypes() {
        return self::$types;
    }

    public static function getType($type) {

        switch ($type) {
            case 'optional':
                return 'Optional';
            case 'facultative':
                return 'Facultativ';
        }

        return 'Obligatoriu';
    }

    public function setGradingSystemAttribute($value) {

        $value = strtolower($value);

        if (in_array($value, self::$gradingSystems)) {
            $this->attributes['grading_system'] = $value;

            return;
        }

        throw new \Exception('Invalid type grading system: ' . $value);
    }

    public static function getGradingSystems() {
        return self::$gradingSystems;
    }

    public static function getGradingSystem($system) {

        switch ($system) {
            case 'qualificatives':
                return 'Calificative';
        }

        return 'Note';
    }
}
