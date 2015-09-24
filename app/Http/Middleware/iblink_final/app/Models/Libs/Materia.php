<?php namespace App\Models\Libs;

class Materia extends \Illuminate\Database\Eloquent\Model 
{

    protected $table = 'subjects';

    // public function clasaelev() 
    // {
    //     return $this->belongsTo('App\Models\Libs\Clasaelev');
    // }    
    public function calculeazaMedii($students, $semesters, $class_id)
    {
    	$where = "(date BETWEEN '" . $semesters[0]->start. "' AND '" . $semesters[0]->end . "') OR (date BETWEEN '" . $semesters[1]->start. "' AND '" . $semesters[1]->end . "')";
        /*
         * Notele
         */
        $toate_notele =
            \DB::table('grades')
            ->whereIn('student_id', $students)
            ->where('class_id', $class_id)
            ->where('grade', '>', 0)
            ->where('absent', 0)
            ->whereRaw($where)
            ->orderby('grade_type','asc')
            ->orderby('date')
            ->get();

        $note_separate = [ 1 => [], 2 => []];
        foreach($note_separate as $i => $notesep)
        {
            foreach($students as $j => $id)
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
            $note_separate[$sem][$nota->student_id][] = $nota;
        }
        
        $medii = [1 => [], 2 => []];

        foreach($note_separate as $i => $elevi)
        {
            foreach($elevi as $j => $note)
            {
                $medii[$i][$j] = str_replace(',', '.', \App\Models\Libs\Noteabsente::calculeazaMedia($note));
            }
        }

        foreach($students as $i => $id)
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
            foreach($students as $j => $id)
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
}