<?php


class Helper
{
	public static function BetweenDates($data, $data1, $data2)
	{
		$d  = strtotime($data);
		$d1 = strtotime($data1);
		$d2 = strtotime($data2);
	
		return ($d1 <= $d) && ($d <= $d2);
	}

	public static function breadcrumb( $urls )
	{
		return \View::make('~libs.~layouts.commons.breadcrumb')->with('urls', $urls)->render();
	}

	// public static function getSTGby( $id )
	// {
	// 	$result = \DB::select(
	// 		"
	// 		select
	// 			stg.id, stg.subject_id, stg.group_id, stg.user_id,
	// 			u.name as teacher_name, u.email as teacher_email,
	// 			g.name as group_name, g.master_id, m.name as master_name, g.institution_id, g.num, g.letter, g.year_id,
	// 			s.name as subject_name, s.type, s.grading_system, s.institution_id
	// 		from subject_teacher_group as stg
	// 		left join subjects as s on stg.subject_id = s.id
	// 		left join groups as g 
	// 			left join users m on g.master_id = m.id
	// 		on stg.group_id = g.id
	// 		left join users as u on stg.user_id = u.id
	// 		where (stg.id = " . $id . ")
	// 		"
	// 	);
	// 	if( count($result) == 0 )
	// 	{
	// 		return NULL;
	// 	}
	// 	return $result[0];
	// }

	// public static function getGradesAbsences( $students, $current_date, $class_id)
	// {
		
	// 	foreach( $students as $i => $student)
	// 	{
	// 		$student->grades[1] = NULL;
	// 		$student->grades[2] = NULL;
	// 		$student->absences[1] = NULL;
	// 		$student->absences[2] = NULL;
	// 		if( $current_date )
	// 		{
	// 			if($current_date->semesters_count > 0)
	// 			{
	// 				$student->grades[1] = \App\Models\Grade::orderBy('date')
	//                 ->where('class_id', $class_id)
	//                 ->where('student_id', $student->id)
	//                 ->where('absent', 0)
	//                 ->where('date', '>=', $current_date->semesters[0]->start)
	//                 ->where('date', '<=', $current_date->semesters[0]->end)
	//                 ->get();
	//                 $student->absences[1] = \App\Models\Grade::orderBy('date')
	//                 ->where('class_id', $class_id)
	//                 ->where('student_id', $student->id)
	//                 ->where('absent', 1)
	//                 ->where('date', '>=', $current_date->semesters[0]->start)
	//                 ->where('date', '<=', $current_date->semesters[0]->end)
	//                 ->get();

	//                 if($current_date->semesters_count > 0)
	// 				{
	// 					$student->grades[2] = \App\Models\Grade::orderBy('date')
	// 	                ->where('class_id', $class_id)
	// 	                ->where('student_id', $student->id)
	// 	                ->where('absent', 0)
	// 	                ->where('date', '>=', $current_date->semesters[1]->start)
	// 	                ->where('date', '<=', $current_date->semesters[1]->end)
	// 	                ->get();
	// 	                $student->absences[2] = \App\Models\Grade::orderBy('date')
	// 	                ->where('class_id', $class_id)
	// 	                ->where('student_id', $student->id)
	// 	                ->where('absent', 1)
	// 	                ->where('date', '>=', $current_date->semesters[1]->start)
	// 	                ->where('date', '<=', $current_date->semesters[1]->end)
	// 	                ->get();
	// 				}
	// 			}
	// 		}
	// 		$student->user = \App\Models\User::where('userable_id', $student->id)->get()->first();
	// 		if($student->user)
 //            {
 //                $student->parents = 
 //                    DB::table('custodian_students')
 //                    ->leftJoin('users', 'custodian_students.custodian_id', '=', 'users.id')
 //                    ->where('student_id', $student->user->id)->get();
 //            }
 //            else
 //            {
 //                $student->parents = NULL;
 //            }
 //            $m1 =  \App\Models\Grade::media($student->grades[1]);
 //            $m2 =  \App\Models\Grade::media($student->grades[2]);
 //            $m  =  \App\Models\Grade::mediagenerala($m1, $m2);
 //            $student->media1 = $m1 ? number_format($m1, 2, ',', '.') : '-';
 //            $student->media2 = $m2 ? number_format($m2, 2, ',', '.') : '-';
 //            $student->media  = $m  ? number_format($m, 2, ',', '.')  : '-';
 
	// 	}
	// }
}