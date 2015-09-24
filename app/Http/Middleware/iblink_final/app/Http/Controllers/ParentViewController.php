<?php namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Grade;
use App\Models\Grades;
use App\Models\Group;
use App\Models\Institution;
use App\Models\Klass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Input;
use Session;

class ParentViewController extends Base\BaseController  {

    public function index() {

        $user        = Auth::user();
        $institution = Institution::current();
        $semester    = $institution->semester;

        /** @var Student $student */
        $student = $user->userable;
        // if custodian logged in - student_id is not current user id
        if ($user->getOriginal('userable_type') == 'custodian') 
        {
            $student_uid = Session::get('student.user.id');
            $student     = User::find($student_uid)->userable;
        }

        /** @var Group $group */
        $group = $student->groups()
                         ->where('year_id', $semester->year_id)
                         ->first();

//        dd($student->groups()->where('year_id', $semester->year_id));

        if ($group) {

            /** @var Collection|Subject[] $subjects */
            $subjects = Subject::select('subjects.*', 'subject_teacher_group.id as class_id', 'users.name as teacher_name')
                               ->join('subject_teacher_group', 'subject_teacher_group.subject_id', '=', 'subjects.id')
                               ->join('users', 'users.id', '=', 'subject_teacher_group.user_id')
                               ->where('group_id', $group->id)
                               ->get();

//            dd($subjects);


            /** @var Collection|Grade[] $grades */
            $grades = Grade::join('subject_teacher_group', 'subject_teacher_group.id', '=', 'grades.class_id')
                           ->where('student_id', $student->id)
                           ->whereIn('class_id', $subjects->lists('class_id'))
                           ->get();

        } else {
            $subjects = new Collection();
            $grades   = new Collection();
        }

        /** @var Collection $groupedGrades */
        $groupedGrades = $grades->groupBy('class_id');

        $avg_sum      = 0;
        $avg_count    = 0;
        $absences_sum = 0;

        foreach ($subjects->keyBy('class_id') as $class_id => $subject) {

            if (!($grades = $groupedGrades->get($class_id))) {

                $subject->average  = 0;
                $subject->grades   = 0;
                $subject->absences = 0;

                continue;
            }

            $grades = new Collection($grades);

            $absences = $grades->filter(function ($item) {
                return $item->absent == 1;
            })->count();

            $absences_sum += $absences;

            /** @var Collection $grades */
            $grades = $grades->filter(function ($item) {
                return $item->grade > 0;
            });

            if ($subject->grading_system == 'grades') {

                $esum = 0;
                $ek   = 0;
                $sum  = 0;
                $k    = 0;

                foreach ($grades as $grade) {
                    if ($grade->grade_type == 'exam') {
                        $ek++;
                        $esum += $grade->grade;
                    } else {
                        $k++;
                        $sum += $grade->grade;
                    }
                }

                $average = $k ? number_format($sum / $k, 2) : 0; // 2 zecimale fara rotunjire

                if ($ek) { // daca exista nota teza
                    $eav     = $esum / $ek;
                    $average = ($average * 3 + $eav) / 4;
                    $average = number_format(round($average));
                }

            } else {

                $cal = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                ];

                foreach ($grades as $grade) {
                    $cal[$grade->grade]++;
                }

                arsort($cal);
                $first = key($cal);

                next($cal);
                $second = key($cal);

                if ($cal[$first] > $cal[$second]) {
                    $average = $first; // predominant
                } else {

                    $sum     = array_sum($grades->lists('grade'));
                    $count   = $grades->count();
                    $last    = $grades->last()->grade;
                    $average = ($sum / $count);

                    if ($average > floor($average) && $last > $average) {
                        $average++;
                    } else {
                        $average = floor($average);
                    }
                }
            }

            $avg_sum += $average;
            ++$avg_count;

            $subject->average = $average;
            $tmp              = [];

            /** @var Grade $grade */
            foreach ($grades as $grade) {
                $tmp [] = $grade->getNiceGrade($subject->grading_system);
            }

            $subject->grades   = implode(', ', $tmp);
            $subject->absences = $absences;
        }

        $general_average = $avg_count ? $avg_sum / $avg_count : 0;

        return view('parent.subjects', [
            'subjects' => $subjects,
            'semester' => $semester,
            'absences' => $absences_sum,
            'average'  => $general_average,
        ]);
    }

    public function show($class_id) {

        $user        = Auth::user();
        $student     = $user->userable;
        $institution = Institution::current();
        $semester    = $institution->semester;

        // if custodian logged in - student_id is not current user id
        if ($user->getOriginal('userable_type') == 'custodian') {
            $student_uid = Session::get('student.user.id');
            $student     = User::find($student_uid)->userable;
        }

        $grades = Grade::where('student_id', $student->id)
                       ->where('class_id', $class_id)
                       ->orderBy('date')
                       ->get();

        $subject = Subject::select('subjects.*')
                          ->join('subject_teacher_group', 'subjects.id', '=', 'subject_teacher_group.subject_id')
                          ->where('subject_teacher_group.id', $class_id)
                          ->first();

        foreach ($grades as $grade) {

            $grade->class = DB::table('subject_teacher_group')
                              ->where('id', $grade->class_id)
                              ->first();

            $grade->subject = Subject::find($grade->class->subject_id);
            $grade->teacher = User::find($grade->class->user_id);
        }

        return view('parent.grades', [
            'student' => $student,
            'subject' => $subject,
            'grades'  => $grades,
        ]);
    }
}
