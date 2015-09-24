<?php namespace App\Models\Libs;

class Elev extends \Illuminate\Database\Eloquent\Model 
{

    protected $table = 'students';

    public function getParinti()
    {
        $sql = "
            SELECT
                custodian_students.*,
                custodians.lastname,
                custodians.firstname,
                custodians.phone,
                custodians.image
            FROM custodian_students
            LEFT JOIN custodians ON custodian_students.custodian_id = custodians.id
            WHERE custodian_students.student_id = " . $this->id . "
        ";
        return \DB::select($sql);
    }

    public function getClasa( $year_id )
    {
        $sql = "
            SELECT
                group_student.id,
                group_student.student_id,
                groups.*,
                teachers.id as teacher_id, teachers.firstname, teachers.lastname, teachers.image
            FROM group_student
            LEFT JOIN groups 
                LEFT JOIN users
                    LEFT JOIN teachers 
                    ON users.userable_id = teachers.id
                ON groups.master_id = users.id
            ON group_student.group_id = groups.id
            WHERE (group_student.student_id = " . $this->id . ") AND (groups.year_id = " . $year_id . ") 
        ";
        $result = \DB::select($sql);
        if( count($result) == 0 )
        {
            return NULL;
        }
        return $result[0];
    }  

    public function getMaterii( $clasa_id )
    {
        $sql = "
            SELECT
                subject_teacher_group.*,
                subjects.name, subjects.grading_system,
                teachers.id as teacher_id, teachers.firstname, teachers.lastname, teachers.image
            FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN users
                LEFT JOIN teachers 
                ON users.userable_id = teachers.id
            ON subject_teacher_group.user_id = users.id
            WHERE subject_teacher_group.group_id = " . $clasa_id . "
        ";
        return \DB::select($sql);
    }

    public function calculeazaMedii( $materii, $semesters )
    {
        $ids = [];
        foreach($materii as $i => $materie)
        {
            $ids[] = $materie->id; 
        }

        $where = "(date BETWEEN '" . $semesters[0]->start. "' AND '" . $semesters[0]->end . "') OR (date BETWEEN '" . $semesters[1]->start. "' AND '" . $semesters[1]->end . "')";

        /*
         * Notele
         */
        $toate_notele =
            \DB::table('grades')
            ->whereIn('class_id', $ids)
            ->where('grade', '>', 0)
            ->where('absent', 0)
            ->whereRaw($where)
            ->orderby('grade_type','asc')
            ->orderby('date')
            ->get();

        $note_separate = [ 1 => [], 2 => []];
        foreach($note_separate as $i => $notesep)
        {
            foreach($ids as $j => $id)
            {
                $note_separate[$i][$id] = [];       
            }
        }
        foreach($toate_notele as $i => $nota)
        {
            if( \Helper::BetweenDates($nota->date, $semesters[0]->start, $semesters[0]->end ) )
            {
                $sem = 1;
            }
            else
            {
                $sem = 2;
            }
            $note_separate[$sem][$nota->class_id][] = $nota;
        }
        
        $medii = [1 => [], 2 => []];

        foreach($note_separate as $i => $materii)
        {
            foreach($materii as $j => $note)
            {
                $medii[$i][$j] = str_replace(',', '.', \App\Models\Libs\Noteabsente::calculeazaMedia($note));
            }
        }

        foreach($ids as $i => $id)
        {
            $k = 0; $sum = 0;
            for($j = 1; $j <= 2; $j++)
            {
                $value = (float) $medii[$j][$id];
                if( $value > 0)
                {
                    $k++;
                    $sum += $value;
                }
            }
            $medii['A'][$id] = ($k == 0) ? '-' : number_format( round($sum/$k, 2), 2, ',', '.');
            //  = round(( + (float) $medii[2][$id])/2, 2);
        }
        
        $medii_generale = [];
        foreach([1, 2, 'A'] as $i => $sem)
        {
            $sum = 0; 
            $k = 0;
            foreach($ids as $j => $id)
            {
                $value = (float) str_replace(',', '.', $medii[$sem][$id]);
                if($value > 0)
                {
                    $sum += $value;
                    $k++;
                }
            }
            $medii_generale[$sem] = ($k == 0) ? '-' : number_format(round($sum/$k, 2), 2, ',', '.');
        }

        return ['medii_materii' => $medii, 'medii_clasa' => $medii_generale];

    }

    public function calculeazTotalAbsente( $materii, $semesters )
    {
        $ids = [];
        foreach($materii as $i => $materie)
        {
            $ids[] = $materie->id; 
        }

        $where = "((date BETWEEN '" . $semesters[0]->start. "' AND '" . $semesters[0]->end . "') OR (date BETWEEN '" . $semesters[1]->start. "' AND '" . $semesters[1]->end . "'))";

        /*
         * Notele
         */
        $toate_absentele =
            \DB::table('grades')
            ->whereIn('class_id', $ids)
            ->where('absent', 1)
            ->whereRaw($where)
            ->orderby('date')
            ->get();

        $absente_separate = [ 1 => [], 2 => []];
        foreach($absente_separate as $i => $notesep)
        {
            foreach($ids as $j => $id)
            {
                $absente_separate[$i][$id] = [];       
            }
        }
        foreach($toate_absentele as $i => $absenta)
        {
            if( \Helper::BetweenDates($absenta->date, $semesters[0]->start, $semesters[0]->end ) )
            {
                $sem = 1;
            }
            else
            {
                $sem = 2;
            }
            $absente_separate[$sem][$absenta->class_id][] = $absenta;
        }
        
        $totaluri = [1 => [], 2 => []];

        foreach($absente_separate as $i => $materii)
        {
            foreach($materii as $j => $absente)
            {
                $totaluri[$i][$j]['motivate'] = 0;
                $totaluri[$i][$j]['nemotivate'] = 0;
                foreach($absente as $k => $absenta)
                {
                    if($absenta->motivated)
                    {
                        $totaluri[$i][$j]['motivate']++;
                    }
                    else
                    {
                        $totaluri[$i][$j]['nemotivate']++;
                    }
                }
                $totaluri[$i][$j]['total'] = $totaluri[$i][$j]['motivate'] + $totaluri[$i][$j]['nemotivate'];
            }
        }

        
        foreach($ids as $i => $id)
        {
            $totaluri['A'][$id]['motivate']   = $totaluri[1][$id]['motivate'] + $totaluri[2][$id]['motivate'];
            $totaluri['A'][$id]['nemotivate'] = $totaluri[1][$id]['nemotivate'] + $totaluri[2][$id]['nemotivate'];
            $totaluri['A'][$id]['total'] = $totaluri['A'][$id]['motivate'] + $totaluri['A'][$id]['nemotivate'];
        }

        $totaluri_generale = [];
        foreach([1, 2, 'A'] as $i => $sem)
        {
            $sum_1 = 0; $sum_2 = 0;
            foreach($ids as $j => $id)
            {
                $value_1 = $totaluri[$sem][$id]['motivate'];
                $sum_1 += $value_1;

                $value_2 = $totaluri[$sem][$id]['nemotivate'];
                $sum_2 += $value_2;
            }
            $totaluri_generale[$sem]['motivate'] = $sum_1;
            $totaluri_generale[$sem]['nemotivate'] = $sum_2;
            $totaluri_generale[$sem]['total'] = $sum_1 + $sum_2;

        }
        return ['absente_materii' => $totaluri, 'absente_clasa' => $totaluri_generale];

    }
}