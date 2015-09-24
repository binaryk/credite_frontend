<?php namespace App\Models\Libs;

class Noteabsente extends \Illuminate\Database\Eloquent\Model 
{

    protected $table = 'grades';

    protected static $types = [
        'grades' => 
            [
                'oral' => 'Oral',
                'test' => 'Test',
                'exam' => 'Teză'
            ],
        'qualificatives' =>
            [
                'oral' => 'Oral',
                'test' => 'Test',
            ],
    ];

    public static function Tipurinote()
    {
        return self::$types;
    }

    public static function TipurinoteToRadio( $id, $grading_system )
    {
        return \View::make('~libs.~layouts.commons.tipuri-note-radio')->with([
            'types' => self::$types[$grading_system],
            'id' => $id
        ])->render();
    }

    public static function calculeazaMedia($note)
    {
    	$sum = 0; $k = 0; $teza = 0;
    	foreach($note as $i => $nota)
    	{
    		if($nota->grade_type == 'exam')
    		{
    			$teza = $nota->grade;
    		}
    		else
    		{
    			$sum += $nota->grade;
    			$k++;
    		}
    	}
    	if( $k > 0)
    	{
    		$media_note = $sum/$k;
    	}
    	else
    	{
    		$media_note = 0; 
    	}
    	$media = ($media_note * ($teza == 0 ? 4 : 3) + $teza) / 4;
    	return ($media == 0) ? '-' : number_format($media, 2, ',', '.');
    }

    public static function getGrades( $ids, $semester )
    {
    	/*
    	 * Notele
    	 */
	    $records =
    		\DB::table('grades')
    		->whereIn('class_id', $ids)
    		->whereRaw('((grade > 0) OR (calificativ is not null))')
    		->where('absent', 0)
    		->where('date', '>=', $semester['start'])
    		->where('date', '<=', $semester['end'])
            ->orderby('date')
    		->orderby('grade_type','asc')
    		->get();

    	$result = [];
    	foreach($ids as $i => $id)
    	{
    		$result[$id]     = [];
    		$activitati[$id] = NULL;
    	}
    	
    	foreach($records as $i => $nota)
    	{
    		$nota->date_short = \Carbon\Carbon::createFromFormat('Y-m-d', $nota->date)->format('d.m');
    		$result[$nota->class_id][] = $nota;
    	}

    	$activities = 
    		\DB::table('student_activities')
    		->whereIn('class_id', $ids)
            ->where('semester_id', $semester['id'])
    		->get();

    	foreach($activities as $i => $activitate)
    	{
    		$activitati[$activitate->class_id] = $activitate;
    	}
    	$rendered = [];
    	foreach($result as $class_id => $note)
    	{
    		$rendered[$class_id]['note']       = \View::make('~libs.parinte.materii-elev.~note')->with('note', $note)->render();
    		$rendered[$class_id]['media']      = self::calculeazaMedia($note);
    		$rendered[$class_id]['activitate'] = \View::make('~libs.parinte.materii-elev.~activitate')->with('activitate', $activitati[$class_id])->render();
    	}
    	return $rendered;
    }


    public static function getAverages( $ids, $student_id, $clasa_id, $semestres)
    {
        $student   = \App\Models\Libs\Elev::find($student_id);
        $materii   = $student->getMaterii($clasa_id);
        $medii     = $student->calculeazaMedii($materii, $semestres);
        return $medii;
    }


    public static function getAbsente( $ids, $semester )
    {
        /*
         * Absentele
         */
        $records =
            \DB::table('grades')
            ->whereIn('class_id', $ids)
            ->where('absent', 1)
            ->where('date', '>=', $semester['start'])
            ->where('date', '<=', $semester['end'])
            ->orderby('date')
            ->get();

        $result = [];
        foreach($ids as $i => $id)
        {
            $result[$id]     = [];
        }
        
        foreach($records as $i => $absenta)
        {
            $absenta->date_short = \Carbon\Carbon::createFromFormat('Y-m-d', $absenta->date)->format('d.m');
            $result[$absenta->class_id][] = $absenta;
        }

        $rendered = [];
        foreach($result as $class_id => $absente)
        {
            $rendered[$class_id]['absente']       = \View::make('~libs.parinte.absente-elev.~absente')->with('absente', $absente)->render();
        }

        return $rendered;
    }

    public static function getAbsenteTotal( $ids, $student_id, $clasa_id, $semestres)
    {
        $student   = \App\Models\Libs\Elev::find($student_id);
        $materii   = $student->getMaterii($clasa_id);
        $medii     = $student->calculeazTotalAbsente($materii, $semestres);
        return $medii;
    }



    /**
     * Creaza inregistrai cu absente pentru toata clasa
     ****/
    public static function insertAbsenteClasa( $date, $student_ids, $class_id, $motivata )
    {
        self::unguard();
        foreach($student_ids as $i => $student_id)
        {
            try
            {
                self::insert([
                    'student_id' => $student_id,
                    'class_id'   => $class_id,
                    'date'       => $date,
                    'grade'      => NULL,
                    'grade_type' => NULL,
                    'absent'     => 1,
                    'motivated'  => $motivata == 'false' ? 0 : 1,
                ]);
            }
            catch(\Exception $e)
            {
                // return ['success' => $student_id . '==>' . $e->getMessage() ];
            }
        }
        return ['success' => true];
    }

    public static function insertNoteClasa( $elevi, $class_id, $grading_system)
    {
        self::unguard();
        foreach($elevi as $i => $elev)
        {
            try
            {
                if( $elev['grade'] > 0)
                {
                    if( ($elev['date']) && ($elev['date'] != '0000-00-00') )
                    {
                        $grade = 
                            $grading_system == 'qualificatives' 
                            ? \App\Models\Grade::toShort( $elev['grade'])
                            :  $elev['grade'];

                        $field = 
                            $grading_system == 'qualificatives' 
                            ? 'calificativ'
                            : 'grade';

                        self::insert([
                            'student_id' => $elev['student_id'],
                            'class_id'   => $class_id,
                            'date'       => $elev['date'],
                            $field       => $grade,
                            'grade_type' => $elev['grade_type'],
                            'absent'     => 0,
                            'motivated'  => 0,
                        ]);
                    }
                }
            }
            catch(\Exception $e)
            {
                // return ['success' => $student_id . '==>' . $e->getMessage() ];
            }
        }
        return ['success' => true];
    }

    /**
     * Informatiile pentru datatable de elevi
     */
    protected static function justIds($students)
    {
        $result = []; 

        foreach($students as $i => $item)
        {
            $result[] = $item['student_id'];
        }
        return $result;
    }

    protected static function getAbsenteClasa($ids, $class_id, $group_id, $semester)
    {
        $records =
            \DB::table('grades')
            ->where('class_id', $class_id)
            ->whereIn('student_id', $ids)
            ->where('absent', 1)
            ->where('date', '>=', $semester['start'])
            ->where('date', '<=', $semester['end'])
            ->orderby('date')
            ->get();
    
        $result = [];
        foreach($ids as $i => $id)
        {
            $result[$id]     = [];
        }
        foreach($records as $i => $absenta)
        {
            $absenta->date_short = \Carbon\Carbon::createFromFormat('Y-m-d', $absenta->date)->format('d.m');
            $result[$absenta->student_id][] = $absenta;
        }
        $rendered = [];
        foreach($result as $student_id => $absente)
        {
            $rendered[$student_id]['html'] = \View::make('~libs.profesor.clasa.~absente')->with('absente', $absente)->render();
        }
        return $rendered;
    }

    protected static function getNoteClasa($ids, $class_id, $group_id, $semester, $grading_system)
    {
        if( $grading_system != 'qualificatives')
        {
            /**
             * NU avem calificative ci avem note normale
             **/
            $records =
                \DB::table('grades')
                ->where('class_id', $class_id)
                ->whereIn('student_id', $ids)
                ->where('grade', '>', 0)
                ->where('absent', 0)
                ->where('date', '>=', $semester['start'])
                ->where('date', '<=', $semester['end'])
                ->orderby('date')
                ->orderby('grade_type','asc')
                ->get();
        }
        else
        {
            /**
             * Avem calificative
             **/
            $records =
                \DB::table('grades')
                ->where('class_id', $class_id)
                ->whereIn('student_id', $ids)
                ->whereRaw('((grade = 0) OR (grade is null))')
                ->whereRaw('calificativ is not null')
                ->where('absent', 0)
                ->where('date', '>=', $semester['start'])
                ->where('date', '<=', $semester['end'])
                ->orderby('date')
                ->orderby('grade_type','asc')
                ->get();
        }

        $result = [];
        foreach($ids as $i => $id)
        {
            $result[$id]     = [];
        }
        
        foreach($records as $i => $nota)
        {
            $nota->date_short = \Carbon\Carbon::createFromFormat('Y-m-d', $nota->date)->format('d.m');
            $result[$nota->student_id][] = $nota;
        }
        $rendered = [];
        foreach($result as $student_id => $note)
        {
            $rendered[$student_id]['html'] = 
                \View::make('~libs.profesor.clasa.~note')->with([
                    'note' => $note,
                    'grading_system' => $grading_system
                ])
                ->render();
            if( $grading_system != 'qualificatives')
            {
                // avem note ==> calculam medii
                $rendered[$student_id]['media'] = self::calculeazaMedia($note);
            }
            else
            {
                $rendered[$student_id]['media'] = '-';   
            }
        }
        return $rendered;
    }

    protected static function getMediiClasa($ids, $class_id, $group_id, $semestres)
    {
        $clasa   = \App\Models\Libs\MaterieProfesorClasa::find($class_id);
        $materia   = \App\Models\Libs\Materia::find($clasa->subject_id);
        $medii     = $materia->calculeazaMedii($ids, $semestres, $class_id);
        return $medii;
    }

    public static function getClasaInformations( $students, $class_id, $group_id, $semester, $semestres, $grading_system )
    {
        /**
         * $grading_system = qualificatives | grades
         **/
        $ids = self::justIds($students);
        $activitati = \DB::table('group_student')->whereIn('student_id', $ids)->where('group_id', $group_id)->get();

        $absente = self::getAbsenteClasa($ids, $class_id, $group_id, $semester);
        $note = self::getNoteClasa($ids, $class_id, $group_id, $semester, $grading_system);
        $medii = self::getMediiClasa($ids, $class_id, $group_id, $semestres);

        return [
            'activitati' => $activitati,
            'absente'    => $absente,
            'note'       => $note,
            'medii'  => $medii,
        ];
    }
}