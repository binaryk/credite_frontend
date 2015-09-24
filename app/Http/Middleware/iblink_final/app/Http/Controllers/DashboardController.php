<?php namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\City;
use App\Models\Country;
use App\Models\County;
use App\Models\Custodian;
use App\Models\Grade;
use App\Models\Institution;
use App\Models\Student;
use App\Models\Teacher;
use Auth;
use Hash;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Input;

class DashboardController extends Base\BaseController  {

    /** @var Request */
    protected $request;

    public function __construct(Request $request) {
        parent::__construct();
        $this->request = $request;
    }

    public function index() 
    {
        if( is_null($user = Auth::user()) )
        {
            return \Redirect::to('auth/login');   
        }
        switch($type = $user->getOriginal('userable_type'))
        {
            case 'teacher' : 
                $view = 'dashboard.teacher';
                break;
            case 'student'   :
            case 'custodian' : 
                $view = 'dashboard.student';
                break;
            default :
                $view = 'dashboard.index';
        }
        if( is_null($institution = Institution::current() ) )
        {
            return \Redirect::to('auth/switcher');
        }

        $adminCount = $institution->users()
                                  ->where('userable_type', Administrator::getStaticMorphClass())
                                  ->count();

        $studentCount = $institution->users()
                                    ->where('userable_type', Student::getStaticMorphClass())
                                    ->count();

        $teacherCount = $institution->users()
                                    ->where('userable_type', Teacher::getStaticMorphClass())
                                    ->count();

        $institution = Institution::current();
        $semester    = $institution->semester;


        $groups = $institution->groups()
                              ->where('year_id', $semester->year_id)
                              ->orderBy('updated_at', 'DESC')
                              ->take(10)
                              ->get();

        /** @var Builder $query */
        $gradeQuery = Grade::join('subject_teacher_group', 'subject_teacher_group.id', '=', 'grades.class_id')
                           ->join('groups', 'subject_teacher_group.group_id', '=', 'groups.id')
                           ->where('groups.year_id', $semester->year_id);

        $absenceQuery = clone $gradeQuery;
        $totalQuery   = clone $gradeQuery;

        $gradeCount = $gradeQuery->whereNotNull('grades.grade')
                                 ->count();

        $absenceCount = $absenceQuery->where('grades.absent', 1)
                                     ->count();

        $totalCount = $totalQuery->count();

        $presenceFloat = $totalCount ? (100 * $absenceCount / $totalCount) : $totalCount;
        $presence      = round($presenceFloat);

        return view($view, [
            'students' => $studentCount,
            'admins'   => $adminCount,
            'teachers' => $teacherCount,
            'grades'   => $gradeCount,
            'presence' => $presence,
            'absences' => $absenceCount,
            'total'    => $totalCount,
            'invoices' => '-',
            'groups'   => $groups,
        ]);
    }

    public function demo() {
        return view('dashboard.demo', [
            'institution' => Institution::current(),
        ]);
    }

    public function profile() {

        $user   = Auth::user();
        $role   = $user->getOriginal('userable_type');
        $method = 'profile_' . $role;

        return $this->$method($user);
    }

    public function profile_superadmin($user) {

        if ($this->request->isMethod('POST')) {

            $this->validate($this->request, [
                'email'    => 'required|email',
                'name'     => 'required',
                'password' => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            ], [
                'email'              => 'Introduceți un email valid',
                'nume'               => 'Câmpul nume este obligatoriu',
                'password.confirmed' => 'Parolele introduse nu coincid',
                'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
                'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            ]);

            $user->email = Input::get('email');
            $user->name  = Input::get('name');

            if (($password = Input::get('password'))) {
                $user->password = Hash::make($password);
            }

            $user->save();

            return redirect()->route('profile');
        }

        return view('dashboard.profile.superadmin', [
            'admin' => $user,
        ]);
    }

    public function profile_admin($user) {

        if ($this->request->isMethod('POST')) {

            $this->validate($this->request, [
                'email'     => 'required|email|unique:users,email,' . $user->id,
                'password'  => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
                'firstname' => 'required',
                'lastname'  => 'required',
                'cnp'       => 'required|digits:13',
            ], [
                'email.required'     => 'Introduceți o adresă de email',
                'email.email'        => 'Introduceți o adresă de email validă',
                'email.unique'       => 'Cineva folosește deja această adresa de email',
                'password.confirmed' => 'Parolele introduse nu coincid',
                'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
                'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
                'firstname.required' => 'Câmpul nume este obligatoriu',
                'lastname.required'  => 'Câmpul prenume este obligatoriu',
                'cnp.required'       => 'Câmpul CNP este obligatoriu',
                'cnp.digits'         => 'Câmpul CNP nu conține 13 cifre'
            ]);

            $user->email = Input::get('email');
            $user->name  = Input::get('firstname') . ' ' . Input::get('firstname');

            if (($password = Input::get('password'))) {
                $user->password = Hash::make($password);
            }

            $user->save();

            /** @var Administrator $admin */
            $admin = $user->userable;

            $admin->fill(Input::all())
                  ->save();

            return redirect()->route('profile');
        }

        return view('dashboard.profile.admin', [
            'admin' => $user->userable,
        ]);
    }

    public function profile_teacher($user) {

        /** @var Teacher $teacher */
        $teacher = $user->userable;

        if ($this->request->isMethod('POST')) {

            $this->validate($this->request, [
                'email'     => 'required|email|unique:users,email,' . $teacher->user->id,
                'password'  => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
                'firstname' => 'required',
                'lastname'  => 'required',
                'cnp'       => 'required|digits:13',
            ], [
                'email.required'     => 'Introduceți o adresă de email',
                'email.email'        => 'Introduceți o adresă de email validă',
                'email.unique'       => 'Cineva folosește deja această adresa de email',
                'password.confirmed' => 'Parolele introduse nu coincid',
                'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
                'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
                'firstname.required' => 'Câmpul nume este obligatoriu',
                'lastname.required'  => 'Câmpul prenume este obligatoriu',
                'cnp.required'       => 'Câmpul CNP este obligatoriu',
                'cnp.digits'         => 'Câmpul CNP nu conține 13 cifre'
            ]);

            $tdata = Input::all();

            $dateFields = ['dob', 'graduated_on', 'employment_date'];

            foreach ($dateFields as $df) {
                if (empty($tdata[$df])) {
                    $tdata[$df] = null;
                } else {
                    $tdata[$df] = date('Y-m-d', strtotime($tdata[$df]));
                }
            }

            $teacher->fill($tdata);
            $teacher->save();

            $password = Input::get('password');

            $teacher->user->name  = implode(' ', Input::only(['firstname', 'lastname']));
            $teacher->user->email = Input::get('email');

            if (!empty($password)) {
                $teacher->user->password = Hash::make($password);
            }

            $teacher->user->save();

            return redirect()->route('profile');
        }

        return view('dashboard.profile.teacher', [
            'teacher'          => $teacher,
            'institution'      => Institution::current(),
            'countries'        => Country::all(),
            'counties'         => County::all(),
            'types'            => Teacher::getAccountTypes(),
            'studies'          => Teacher::getStudyTypes(),
            'positions'        => Teacher::getPositions(),
            'degrees'          => Teacher::getDegrees(),
            'developments'     => Teacher::getDevelopments(),
            'employment_types' => Teacher::getEmploymentTypes(),
        ]);
    }

    public function profile_student($user) {

        /** @var Student $student */
        $student = $user->userable;

        if ($this->request->isMethod('POST')) {

            $this->validate($this->request, [
                'email'    => 'required|email|unique:users,email,' . $student->user->id,
                'password' => ['required', 'regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            ], [
                'email.required'     => 'Introduceți o adresă de email',
                'email.email'        => 'Introduceți o adresă de email validă',
                'email.unique'       => 'Cineva folosește deja această adresa de email',
                'password.confirmed' => 'Parolele introduse nu coincid',
                'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
                'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            ]);

            $tdata = Input::only(['email', 'firstname', 'lastname', 'image']);

            $student->fill($tdata);
            $student->save();

            if (($password = Input::get('password'))) {
                $student->user->password = Hash::make($password);
            }

            $student->user->email = Input::get('email');
            $student->user->save();

            return redirect()->route('profile');
        }

        $languages = [
            'romanian' => 'Română',
            'english'  => 'Engleză',
            'finnish'  => 'Finlandeză',
        ];

        return view('dashboard.profile.student', [
            'student'   => $student,
            'countries' => Country::all(),
            'counties'  => County::all(),
            'cities'    => City::all(),
            'genders'   => Student::getGenders(),
            'languages' => $languages,
        ]);
    }

    public function profile_custodian($user) {

        /** @var Custodian $custodian */
        $custodian = $user->userable;

        if ($this->request->isMethod('POST')) {

            $this->validate($this->request, [
                'lastname'  => 'required',
                'firstname' => 'required',
                'password'  => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
                'email'     => 'required|email|unique:users,email,' . $custodian->user->id,
            ], [
                'lastname.required'  => 'Câmpul nume este obligatoriu',
                'firstname.required' => 'Câmpul prenume este obligatoriu',
                'password.confirmed' => 'Parolele introduse nu coincid',
                'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
                'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
                'email.required'     => 'Câmpul email este obligatoriu',
                'email.email'        => 'Nu ați introdus o adresa validă de email',
                'email.unique'       => 'Cineva folosește deja această adresa de email',
            ]);

            $custodian->fill(Input::all());
            $custodian->save();

            /** @var User $user */
            $user = $custodian->user;

            $user->fill([
                'name'  => $custodian->firstname . ' ' . $custodian->lastname,
                'email' => Input::get('email'),
            ]);

            if (($password = Input::get('password'))) {
                $user->password = Hash::make($password);
            }

            $user->save();

            return redirect()->route('profile');
        }

        return view('dashboard.profile.custodian', [
            'custodian' => $custodian,
        ]);
    }
}
