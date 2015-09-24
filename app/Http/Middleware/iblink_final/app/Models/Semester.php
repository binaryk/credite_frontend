<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model {

    public function year() {
        return $this->belongsTo('\App\Models\Year');
    }

    public function institutions() {
        return $this->hasMany('\App\Models\Institution');
    }

    public static function getSemester($data){
    	$semester = \DB::table('semesters')
    	->leftJoin('years', 'semesters.year_id', '=', 'years.id')
    	->where('start','<=', $data)->where('end', '>=', $data)
    	->select(['semesters.id', 'semesters.name', 'semesters.start', 'semesters.end', 'years.name as yearname', 'semesters.year_id'])
    	->get();
    	if(count($semester) == 0)
    	{
    		return NULL;
    	}
    	return $semester[0];
    }

    public static function getBoth($year_id){
    	return self::where('year_id', $year_id)->get();
    }
}
