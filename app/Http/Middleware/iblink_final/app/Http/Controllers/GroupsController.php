<?php namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Year;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Institution;
use Input;

class GroupsController extends Base\BaseController  {

    use ValidatesRequests;

    /** @var Request */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
        parent::__construct();
    }

    public function index() {

        $institution = Institution::current();

        /** @var Semester $semester */
        $semester = $institution->semester;

        /** @var Year $year */
        $year = $semester->year;

        /** @var Collection|Group[] $groups */
        $groups = $year->groups()
                       ->with('students')
                       ->where('institution_id', $institution->id)
                       ->orderBy('num')
                       ->orderBy('letter')
                       ->get();
        //$groups = $institution->groups()
        //                      ->where('year_id', $year->id)
        //                      ->orderBy('num')
        //                      ->orderBy('letter')
        //                      ->get();

        $groups->load('master');

        $semester = $institution->semester;
        $year = $semester->year;
        return view('groups.index', [
            'groups' => $groups,
            'year' => $year,
            'semester' => $semester,
        ]);
    }

    public function add() {

        $institution = Institution::current();
        $semester    = $institution->semester;
        $year        = $semester->year;

        $teachers = $institution->users()
                                ->where('userable_type', Teacher::getStaticMorphClass())
                                ->get(); 


        return view('groups.add', [
            'teachers' => $teachers,
            'years'    => Year::all(),
            'active'   => $year->id,
        ]);
    }

    public function addPost() {

        $this->validate($this->request, [
            'master_id' => 'exists:users,id,userable_type,teacher',
            'num'       => 'required',
            'letter'    => 'required',
        ], [
            'num.required'    => 'Nu aÈ›i selectat clasa',
            'letter.required' => 'Nu aÈ›i selectat litera',
        ]);

        $group = new Group(Input::all());

        $institution = Institution::current();
        $semester    = $institution->semester;
        $year        = $semester->year;

        $group->institution_id = $institution->id;
        $group->year_id        = $year->id;

        $group->selfRename();
        $group->save();

        return redirect()
            ->route('groups');
    }

    public function edit(Group $group) {

        $teachers = Institution::current()
                               ->users()
                               ->where('userable_type', Teacher::getStaticMorphClass())
                               ->get();

        return view('groups.edit', [
            'group'    => $group,
            'teachers' => $teachers,
            'years'    => Year::all(),
        ]);
    }

    public function editPost(Group $group) {

        $this->validate($this->request, [
            'master_id' => 'exists:users,id,userable_type,teacher',
            'num'       => 'required',
            'letter'    => 'required',
        ], [
            'num.required'    => 'Nu aÈ›i selectat clasa',
            'letter.required' => 'Nu aÈ›i selectat litera',
        ]);

        $group->fill(Input::except(['name']));

        $group->selfRename();
        $group->save();

        return redirect()
            ->route('groups');
    }

    public function remove(Group $group) {
     
        return redirect()
            ->route('groups');
    }

    public function students(Group $group) {

        $students = $group->students()->get();

        return view('groups.students.index', [
            'group'    => $group,
            'students' => $students,
        ]);
    }

    public function studentsAdd(Group $group) {

        $institution = Institution::current();
        $semester    = $institution->semester;

        /** @var Collection|Group[] $groups */
        $groups = Group::where('year_id', $semester->year_id)
                       ->get()
                       ->lists('id');

        $students = DB::table('group_student')
                      ->join('groups', function (JoinClause $join) use ($semester) {
                          $join->on('group_student.group_id', '=', 'groups.id')
                               ->where('groups.year_id', '=', $semester->year_id);
                      })
                      ->rightJoin('students', 'students.id', '=', 'group_student.student_id')
                      ->whereNull('group_student.group_id')
                      ->get();

        $students = Student::hydrate($students);

        return view('groups.students.add', [
            'group'    => $group,
            'students' => $students,
        ]);
    }

    public function studentsAddPost(Group $group) {

        $group->students()->attach(Input::get('students'));

        return redirect()->route('groups.students', ['group' => $group]);
    }

    public function studentRemove(Group $group, Student $student) {

        $group->students()->detach($student->id);

        return redirect()->route('groups.students', ['group' => $group]);
    }

    public function subjects(Group $group) {

        $subjects = $group->subjects()
                          ->withPivot(['id', 'user_id'])
                          ->get();

        return view('groups.subjects.index', [
            'group'    => $group,
            'subjects' => $subjects,
        ]);
    }

    public function subjectsAdd(Group $group) {



        $institution = Institution::current();

        $users = Institution::current()
                            ->users()
                            ->where('userable_type', Teacher::getStaticMorphClass())
                            ->get();

        $users->load('userable');

        $system = $group->num > 4 ? 'grades' : 'qualificatives';

        $subjects = Subject::where('institution_id', $institution->id)
                           ->where('grading_system', $system)
                           ->get();



        return view('groups.subjects.add', [
            'group'       => $group,
            'institution' => $institution,
            'users'       => $users,
            'subjects'    => $subjects,
        ]);
    }

    public function subjectsAddPost(Group $group) {

        $this->validate($this->request, [
            'subject' => 'required',
            'teacher' => 'required',
        ], [
            'subject.required' => 'Nu aÈ›i selectat disciplina',
            'teacher.required' => 'Nu aÈ›i selectat profesorul',
        ]);

        DB::table('subject_teacher_group')
          ->insert([
              'group_id'   => $group->id,
              'subject_id' => Input::get('subject'),
              'user_id'    => Input::get('teacher'),
          ]);

        return redirect()->route('groups.subjects', ['group' => $group]);
    }

    public function subjectRemove(Group $group, $pivot) {

        DB::table('subject_teacher_group')
          ->where('id', $pivot)
          ->delete();

        return redirect()->route('groups.subjects', ['group' => $group]);
    }

}