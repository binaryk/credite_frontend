<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model {

    protected static $grades = [
        1  => 1,
        2  => 2,
        3  => 3,
        4  => 4,
        5  => 5,
        6  => 6,
        7  => 7,
        8  => 8,
        9  => 9,
        10 => 10,
    ];

    protected static $quals = [
        '1' => 'I',
        '2' => 'S',
        '3' => 'B',
        '4' => 'FB',
    ];

    protected static $short_quals = [
        '1' => 'I',
        '2' => 'S',
        '3' => 'B',
        '4' => 'FB',
    ];

    protected static $types = [
        'test' => 'Test',
        'oral' => 'Oral',
        'exam' => 'Teză'
    ];

    public function setUpdatedAt($value){}

    public function getUpdatedAtColumn(){}

    public static function toShort( $value )
    {
        return self::$short_quals[$value];
    }

    public static function getGrades($type = 'grades') 
    {
        if ($type == 'grades') 
        {
            return self::$grades;
        }
        return self::$quals;
    }

    public static function getGradeTypes($type = 'grades') {

        $types = self::$types;

        if ($type == 'grades') {
            return $types;
        }

        unset($types['exam']);

        return $types;
    }

    public function getGradeType() {

        if (isset(self::$types[$this->grade_type])) {
            return self::$types[$this->grade_type];
        }

        return '';
    }

    public function getNiceGrade($type = 'grades') {

        if ($type == 'grades') {
            return $this->grade;
        }

        if (isset(self::$quals[$this->grade])) {
            return self::$quals[$this->grade];
        }

        return $this->grade;
    }

    public static function getNiceGradeStatic($grade, $type = 'grades') {

        if ($type == 'grades') {
            return $grade;
        }

        if (isset(self::$quals[$grade])) {
            return self::$quals[$grade];
        }

        return $grade;
    }

    public static function media($grades)
    {
        if($grades->count() == 0)
        {
            return NULL;
        }
        $suma = 0;
        foreach($grades as $i => $grade)
        {
            $suma += $grade->grade;
        }
        return $suma/$grades->count();
    }

    public static function mediagenerala($media_1, $media_2)
    {
        if(! $media_1 && ! $media_2)
        {
            return NULL;
        }

        if($media_1 && $media_2)
        {
            return ($media_1 + $media_2)/2;
        }

        if($media_1)
        {
            return $media_1;
        }
        return $media_2;
    }

}
