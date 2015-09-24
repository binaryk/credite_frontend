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

class TeacherGroupsController extends Base\BaseController 
{

    /**
     * Clasele unui profesor
     * $classid = id-ul din subject_teacher_group
     **/
    public function index() 
    {
        $teacher = $this->current_user;
        $groups  = $teacher->userable
            ->groups()
            ->where('year_id', $this->current_date->semester->year_id)
            ->withPivot('id', 'subject_id')
            ->get();
        return view('teacher.groups', [
            'groups'      => $groups,
            'teacher'     => $teacher,
            'has_actions' => false
        ]);
    }

    /**
     * Elevii unei clase
     * aici e ajunge de pe Clasele mele => Deschide
     * $classid = id-ul din subject_teacher_group
     **/
    public function show($classid) 
    {
        /**
         * aflu inregistrarea din subject_teacher_group (materia, clasa, profesor)
         ***/
        $subject_teacher_group = \Helper::getSTGby( $classid );
        if( is_null($subject_teacher_group) ) 
        {
            abort(404);
        }

        // dd($this->current_date);
        /**
         * Aflu studentii
         **/
        $students = 
            DB::table('group_student')
             ->leftJoin('students', 'group_student.student_id', '=', 'students.id')
             ->where('group_id', $subject_teacher_group->group_id)
             ->orderBy('students.lastname')
             ->orderBy('students.firstname')
             ->get();


        \Helper::getGradesAbsences($students, $this->current_date, $subject_teacher_group->id);

        return view('teacher.group', [
            'has_actions' => false,
            // 'semester' => $semestru,
            'students' => $students,
            // // 'class'   => $class,
            // 'group'   => $group,
            // // 'subject' => $subject,
            'subject_teacher_group' => $subject_teacher_group
        ]);
    }

    /**
     * ============================================================================================================
     **/
    public function addGrade()
    {
        // dd(Input::all());
        Grade::unguard();
        Grade::insert([
            'student_id' => Input::get('student_id'),
            'class_id'   => Input::get('class_id'),
            'date'       => Input::get('date'),
            'grade'      => Input::get('grade'),
            'grade_type' => Input::get('grade_type')
        ]);
        return \Response::json(['success' => true]);
    }

    public function addAbsence()
    {
        // dd(Input::all());
        Grade::unguard();
        Grade::insert([
            'student_id' => Input::get('student_id'),
            'class_id'   => Input::get('class_id'),
            'date'       => Input::get('date'),
            'absent'     => 1   
        ]);
        return \Response::json(['success' => true]);
    }

    public function sendMessage()
    {

        \Mail::send('emails.message-teacher-to-student', [
            'content'     => Input::get('message'), 
            'teachername' => Auth::user()->name,
            'firstname'   => Input::get('firstname'),
            'lastname'    => Input::get('lastname')],function($message)
        {
            $message->to(Input::get('email'))->subject(Input::get('subject'));
        });
        return \Response::json(['success' => true]);
    }

    public function grades($classid, $date = false) {

        $now = time();

        if ($date !== false) {

            $time = strtotime($date);

            if ($time > $now) {
                return redirect()->back();
            }

            $now = $time;
        }

        $date = date('d.m.Y', $now);

        $class = DB::table('subject_teacher_group')
                   ->where('id', $classid)
                   ->first();

        $subject = Subject::find($class->subject_id);

        $group = Group::with('students')
                      ->find($class->group_id);

        $grades = DB::table('grades')
                    ->where('class_id', $classid)
                    ->where('date', date('Y-m-d', $now))
                    ->get();

        $grades = (new Collection($grades))->keyBy('student_id');

        return view('teacher.grades', [
            'class'   => $class,
            'group'   => $group,
            'subject' => $subject,
            'grades'  => $grades,
            'date'    => $date,
        ]);
    }

    public function gradesPost($classid) {

        $now = strtotime(Input::get('date'));

        if (Input::get('action') == 'changeDate') {

            return redirect()->route('teacher.grades', [
                'class' => $classid,
                'date'  => Input::get('date'),
            ]);
        }

        $class = DB::table('subject_teacher_group')
                   ->where('id', $classid)
                   ->first();

        $group = Group::with('students')->find($class->group_id);

        $grades      = Input::get('grade');
        $grade_types = Input::get('grade_type');
        $presence    = Input::get('presence');
        $motivated   = Input::get('motivated');

        foreach ($group->students as $student) {

            $absent = isset($presence[$student->id]) ? 0 : 1;
            $mot    = isset($motivated[$student->id]) ? $motivated[$student->id] : null;
            $grade  = isset($grades[$student->id]) ? $grades[$student->id] : 0;
            $type   = isset($grade_types[$student->id]) ? $grade_types[$student->id] : 'test';

            if ($absent || !$grade) {
                $grade = null;
                $type  = null;
            }

            if (!$absent) {
                $mot = null;
            }

            if (!$absent && !$grade) {

                DB::table('grades')
                  ->where([
                      'student_id' => $student->id,
                      'class_id'   => $classid,
                      'date'       => date('Y-m-d', $now),
                  ])
                  ->delete();

                continue;
            }

            DB::insert('
                INSERT INTO `grades`
                (`student_id`, `class_id`, `date`, `grade`, `grade_type`, `absent`, `motivated`)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY
                UPDATE grade = VALUES(grade), grade_type = VALUES(grade_type), absent = VALUES(absent), motivated = VALUES(motivated)
            ', [
                $student->id, $classid, date('Y-m-d', $now), $grade, $type, $absent, $mot
            ]);
        }

        return redirect()->route('teacher.group', [
            'class' => $classid,
            //'date'  => date('d.m.Y', $now),
        ]);
    }
}
