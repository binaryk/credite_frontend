<?php namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Institution;
use Input;

class SubjectsController extends Base\BaseController  {

    use ValidatesRequests;
    
    protected $request;

    public function __construct(Request $request) 
    {
        parent::__construct();
        $this->request = $request;
    }

    public function index() {

        /** @var Collection|Subject[] $subjects */
        $subjects = Institution::current()
                               ->subjects()
                               ->orderBy('name')
                               ->get();

        return view('subjects.index', [
            'subjects' => $subjects
        ]);
    }

    public function add() {
        return view('subjects.add', [
            'institution' => Institution::current(),
            'types'       => Subject::getTypes(),
            'systems'     => Subject::getGradingSystems(),
            'teachers'    => Teacher::toCombobox()
        ]);
    }

    public function addPost(SubjectRequest $request) {

        $types   = Subject::getTypes();
        $systems = Subject::getGradingSystems();

        $subject = new Subject(Input::only(['name', 'type','teacher_id', 'grading_system', 'institution_id']));
        $subject->save();

        return redirect()
            ->route('subjects');
    }

    public function edit(Subject $subject) {

        return view('subjects.edit', [
            'subject'         => $subject,
            'institution'     => Institution::current(),
            'types'           => Subject::getTypes(),
            'grading_systems' => Subject::getGradingSystems(),
            'teachers'    => Teacher::toCombobox(),
            'systems'     => Subject::getGradingSystems(),
        ]);
    }

    public function editPost(Subject $subject, SubjectRequest $request) {

        $types   = Subject::getTypes();
        $systems = Subject::getGradingSystems();

        $subject->fill(Input::only(['name', 'type','teacher_id', 'grading_system','institution_id']));
        $subject->save();

        return redirect()
            ->route('subjects');
    }

    public function remove(Subject $subject) {

        $subject->delete();

        return redirect()
            ->route('subjects');
    }
}
