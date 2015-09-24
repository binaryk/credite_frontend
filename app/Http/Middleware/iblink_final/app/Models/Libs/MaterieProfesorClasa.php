<?php namespace App\Models\Libs;

class MaterieProfesorClasa extends \Illuminate\Database\Eloquent\Model 
{

    protected $table = 'subject_teacher_group';

    // public function clasaelev() 
    // {
    //     return $this->belongsTo('App\Models\Libs\Clasaelev');
    // }    

    public static function getRecord( $id )
    {
    	$sql = "
    		SELECT
    			subject_teacher_group.*,
                subjects.name as materia, subjects.grading_system,
                groups.name as clasa
    		FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN groups ON subject_teacher_group.group_id = groups.id
    		WHERE subject_teacher_group.id = " . $id ."
    	";
    	$result = \DB::select($sql);
    	if( count($result) == 0)
    	{
    		return null;
    	}
    	return $result[0];
    }
}