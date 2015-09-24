<?php namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\County;
use App\Models\Custodian;
use App\Models\Student;
use App\Models\User;
use App\Services\InvitationSender;
use DB;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Institution;
use Input;

class StudentsController extends Base\BaseController  {

    use ValidatesRequests;

    /** @var Request */
    protected $request;

    protected $languages = [
        'romanian' => 'Română',
        'english'  => 'Engleză',
        'finnish'  => 'Finlandeză',
    ];

    public function __construct(Request $request, InvitationSender $inviter) {
        $this->request = $request;
        $this->inviter = $inviter;
        parent::__construct();
    }

    public function index() {

        /** @var Collection|User[] $users */
        $users = Institution::current()
                            ->users()
                            ->where('userable_type', Student::getStaticMorphClass())
                            ->paginate(30);
        $users->load('userable');
        $yid = Institution::current()->semester->year_id;

        foreach ($users as $user) {
            /** @var Student $student */
            $student     = $user->userable;
            $user->group = $student->groups()->where('year_id', $yid)->first();
        }
        return view('students.index', [
            'users' => $users
        ]);
    }

    public function add() {
        return view('students.add', [
            'countries' => Country::all(),
            'genders'   => Student::getGenders(),
            'languages' => $this->languages,
        ]);
    }

    public function addPost() {

        $this->validate($this->request, [
            'email'                     => 'required|email|unique:users,email',
            'firstname'                 => 'required',
            'lastname'                  => 'required',
            'dob'                       => 'required',
            'cnp'                       => 'required|digits:13',
            "parents_initials"          => "required",
            "gender"                    => "in:" . implode(',', Student::getGenders()),
            "emergency_phone"           => "required",
            "secondary_emergency_phone" => "required",
            'password' => ['required', 'regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],

        ], [
            'firstname.required'                 => 'Câmpul nume este obligatoriu',
            'lastname.required'                  => 'Câmpul prenume este obligatoriu',
            'dob.required'                       => 'Nu ați introdus data nașterii',
            'cnp.required'                       => 'Câmpul CNP este obligatoriu',
            'parents_initials.required'          => 'Câmpul inițiala tatălui este obligatoriu',
            'emergency_phone.required'           => 'Nu ați introdus un număr de telefon de urgență',
            'secondary_emergency_phone.required' => 'Nu ați introdus un număr de telefon secundar de urgență',
            'password.required'  => 'Câmpul parolă este obligatoriu',
            'password.confirmed' => 'Parolele introduse nu coincid',
            'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
            'password.regex' => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
        ]);

        $tfields = [
            'lastname', 'parents_initials', 'firstname', 'gender',
            'dob', 'cnp', 'nationality', 'emergency_name', 'emergency_phone',
            'secondary_emergency_name', 'secondary_emergency_phone', 'image',
        ];

        $tdata = Input::only($tfields);

        if (empty($tdata['dob'])) {
            $tdata['dob'] = null;
        } else {
            $tdata['dob'] = date('Y-m-d', strtotime($tdata['dob']));
        }

        $tdata['institution_id'] = Institution::current()->id;

        $student = Student::create($tdata);
        $student->save();

        $user = User::create([
            'email'    => Input::get('email'),
            'name'     => implode(' ', Input::only(['firstname', 'lastname'])),
            'password' => Hash::make(Input::get('password')),
        ]);

        $user->userable_id   = $student->id;
        $user->userable_type = $student->getMorphClass();

        $user->save();

        Institution::current()->users()->save($user);

        $this->inviter->emailInvitationLink($user, Institution::current());

        return redirect()
            ->route('students');
    }

    public function edit(Student $student) {
        return view('students.edit', [
            'student'   => $student,
            'countries' => Country::all(),
            'counties'  => County::all(),
            'cities'    => City::all(),
            'genders'   => Student::getGenders(),
            'languages' => $this->languages,
        ]);
    }

    public function editPost(Student $student) {

        $this->validate($this->request, [
            'email'                     => 'required|email|unique:users,email,' . $student->user->id,
            'password'                  => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            'firstname'                 => 'required',
            'lastname'                  => 'required',
            'dob'                       => 'required',
            'cnp'                       => 'required|digits:13',
            "parents_initials"          => "required",
            "gender"                    => "in:" . implode(',', Student::getGenders()),
            "emergency_phone"           => "required",
            "secondary_emergency_phone" => "required",
        ], [
            'email.required'                     => 'Introduceți o adresă de email',
            'email.email'                        => 'Introduceți o adresă de email validă',
            'email.unique'                       => 'Cineva folosește deja această adresa de email',
            'password.confirmed'                 => 'Parolele introduse nu coincid',
            'password.min'                       => 'Parola trebuie să aibă minim 7 caractere',
            'password.regex'                     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            'firstname.required'                 => 'Câmpul prenume este obligatoriu',
            'lastname.required'                  => 'Câmpul numele de familie este obligatoriu',
            'dob.required'                       => 'Nu ați introdus data nașterii',
            'cnp.required'                       => 'Câmpul CNP este obligatoriu',
            'cnp.digits'                         => 'Câmpul CNP nu conține 13 cifre',
            'parents_initials.required'          => 'Câmpul inițiala tatălui este obligatoriu',
            'emergency_phone.required'           => 'Nu ați introdus un număr de telefon de urgență',
            'secondary_emergency_phone.required' => 'Nu ați introdus un număr de telefon secundar de urgență',
        ]);

        $tfields = [
            'lastname', 'parents_initials', 'firstname', 'gender',
            'dob', 'cnp', 'nationality', 'emergency_name', 'emergency_phone',
            'secondary_emergency_name', 'secondary_emergency_phone', 'image',
        ];

        $tdata = Input::only($tfields);

        if (empty($tdata['dob'])) {
            $tdata['dob'] = null;
        } else {
            $tdata['dob'] = date('Y-m-d', strtotime($tdata['dob']));
        }

        $student->fill($tdata);
        $student->save();

        if (($password = Hash::make(Input::get('password')) )) {
            $student->user->password = $password;
        }

        $student->user->email = Input::get('email');
        $student->user->save();

        return redirect()
            ->route('students');
    }

    public function remove(Student $student) {

        $student->user->delete();
        $student->delete();

        return redirect()
            ->route('students');
    }

    public function custodians(Student $student) {;

        $custodiansUsers = $student->custodians;
        $custodiansUsers->load('userable');

        return view('students.parents.index', [
            'student' => $student,
            'users'   => $custodiansUsers,
        ]);
    }

    public function custodiansAdd(Student $student) {
        return view('students.parents.add', [
            'student' => $student,
        ]);
    }

    public function custodiansAddPost(Student $student) {

        $this->validate($this->request, [
            'lastname'  => 'required',
            'firstname' => 'required',
            'password'  => ['required', 'regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            'email'     => 'required|email|unique:users,email',
        ], [
            'lastname.required'  => 'Câmpul nume este obligatoriu',
            'firstname.required' => 'Câmpul prenume este obligatoriu',
            'password.required'  => 'Câmpul parolă este obligatoriu',
            'password.confirmed' => 'Parolele introduse nu coincid',
            'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
            'password.regex'     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            'email.required'     => 'Câmpul email este obligatoriu',
            'email.email'        => 'Nu ați introdus o adresa validă de email',
            'email.unique'       => 'Cineva folosește deja această adresa de email',
        ]);

        $custodian = new Custodian(Input::all());
        $custodian->save();

        $user = new User([
            'name'     => $custodian->firstname . ' ' . $custodian->lastname,
            'email'    => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
        ]);

        $user->userable_type = Custodian::getStaticMorphClass();
        $user->userable_id   = $custodian->id;

        $user->save();

        $this->inviter->emailInvitationLink($user, Institution::current(), $student);

        DB::table('custodian_students')->insert([
            'student_id'   => $student->user->id,
            'custodian_id' => $user->id,
        ]);

        return redirect()
            ->route('students.custodians', ['student' => $student]);
    }

    public function custodiansEdit(Student $student, Custodian $custodian) {
        return view('students.parents.edit', [
            'student'   => $student,
            'custodian' => $custodian,
        ]);
    }

    public function custodiansEditPost(Student $student, Custodian $custodian) {

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

        return redirect()
            ->route('students.custodians', ['student' => $student]);
    }

    public function custodiansFind(Student $student) {
        return view('students.parents.find', [
            'student' => $student,
        ]);
    }

    public function custodiansRemove(Student $student, Custodian $custodian) {

        DB::table('custodian_students')->where([
            'student_id'   => $student->user->id,
            'custodian_id' => $custodian->user->id,
        ])->delete();

        return redirect()
            ->route('students.custodians', ['student' => $student]);
    }

    public function custodiansFindPost(Student $student) {

        $this->validate($this->request, [
            'email' => 'required|exists:users,email,userable_type,custodian',
        ], [
            'email.required' => 'Introduceți o adresă de email',
            'email.exists'   => 'Nu a fost găsit nici un părinte cu această adresă de email',
        ]);

        $user = User::where('email', Input::get('email'))->first();

        $count = DB::table('custodian_students')
                   ->where('custodian_id', $user->id)
                   ->where('student_id', $student->user->id)
                   ->count();

        if ($count == 0) {
            DB::table('custodian_students')->insert([
                'student_id'   => $student->user->id,
                'custodian_id' => $user->id,
            ]);
        }

        return redirect()
            ->route('students.custodians', ['student' => $student]);
    }

    public function gradesIndex()
    {
        return view('students.grades.index');
    }

}
