<?php namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Year;
use App\Models\Institution;

class YearsController extends Base\BaseController  
{

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {

        $years = Year::with('semesters')->get();

        return view('years.index', [
            'years'   => $years,
            'mocked'  => Institution::current()->active_semester_id,
            'current' => Institution::current()->getOriginal('active_semester_id'),
        ]);
    }

    public function active(Semester $semester) {

        $institution = Institution::current();

        Institution::mock($semester);
        $institution->active_semester_id = $semester->id;
        $institution->save();

        return redirect()
            ->route('years');
    }

    public function mock(Semester $semester) {

        Institution::mock($semester);

        return redirect()
            ->route('years');
    }

}
