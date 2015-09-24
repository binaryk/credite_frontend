<?php namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\County;
use App\Models\Institution;
use App\Models\Teacher;
use App\Models\User;
use App\Services\InvitationSender;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Input;
use App\Http\Requests\TeachersRequest; 
use App\Models\Helpers\Image;
class TeachersController extends Base\BaseController  {

	use ValidatesRequests;

	/** @var Request */
	protected $request;

	public function __construct(Request $request, InvitationSender $inviter) {
		parent::__construct();
		$this->request = $request;
		$this->inviter = $inviter;
	}

	public function index() {

		/** @var Collection|User[] $users */
		$users = Institution::current()
							->users()
							->where('userable_type', Teacher::getStaticMorphClass())
							->get();
		$users->load('userable');

		// $t = $users[0]->userable;
		 // dd($t);
		 // dd($users);
		 // die();

		return view('teachers.index', [
			'users' => $users,
			// 'institution' => Institution::current(),
		]);
	}

	public function add() {
		return view('teachers.add', [
			'institution' => Institution::current(),
			'countries' => Country::all(),
			'counties' => County::all(),
			'types' => Teacher::getAccountTypes(),
			'studies' => Teacher::getStudyTypes(),
			'positions' => Teacher::getPositions(),
			'degrees' => Teacher::getDegrees(),
			'developments' => Teacher::getDevelopments(),
			'employment_types' => Teacher::getEmploymentTypes(),
		]);
	}

	public function addPost(TeachersRequest $request) {

		$tdata = Input::all();

		// clean date fields
		$dateFields = ['dob', 'graduated_on', 'employment_date'];

		foreach ($dateFields as $df) {
			if (empty($tdata[$df])) {
				$tdata[$df] = null;
			} else {
				$tdata[$df] = date('Y-m-d', strtotime($tdata[$df]));
			}
		}
        $teacher = Teacher::create($tdata);
        $teacher->save();
		$user = User::create([
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'name' => implode(' ', Input::only(['firstname', 'lastname'])),
		]);

		$user->userable_id = $teacher->id;
		$user->userable_type = $teacher->getMorphClass();

		$user->save();

		Institution::current()->users()->save($user);

		$this->inviter->emailInvitationLink($user, Institution::current());

		return redirect()
			->route('teachers');
	}

	public function edit(Teacher $teacher) {
		return view('teachers.edit', [
			'teacher' => $teacher,
			'institution' => Institution::current(),
			'countries' => Country::all(),
			'counties' => County::all(),
			'types' => Teacher::getAccountTypes(),
			'studies' => Teacher::getStudyTypes(),
			'positions' => Teacher::getPositions(),
			'degrees' => Teacher::getDegrees(),
			'developments' => Teacher::getDevelopments(),
			'employment_types' => Teacher::getEmploymentTypes(),
		]);
	}

	public function editPost(Teacher $teacher, TeachersRequest $request) {

		$this->validate($this->request, [
			'email' => 'required|email|unique:users,email,' . $teacher->user->id,
			'password' => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
			'firstname' => 'required',
			'lastname' => 'required',
			'cnp' => 'required|digits:13',
		], [
			'email.required' => 'Introduceți o adresă de email',
			'email.email' => 'Introduceți o adresă de email validă',
			'email.unique' => 'Cineva folosește deja această adresa de email',
			'password.confirmed' => 'Parolele introduse nu coincid',
			'password.min' => 'Parola trebuie să aibă minim 7 caractere',
			'password.regex' => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
			'firstname.required' => 'Câmpul nume este obligatoriu',
			'lastname.required' => 'Câmpul prenume este obligatoriu',
			'cnp.required' => 'Câmpul CNP este obligatoriu',
			'cnp.digits' => 'Câmpul CNP nu conține 13 cifre',
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

		$teacher->user->name = implode(' ', Input::only(['firstname', 'lastname']));
		$teacher->user->email = Input::get('email');

		if (!empty($password)) {
			$teacher->user->password = Hash::make($password);
		}

		$teacher->user->save();

		return redirect()
			->route('teachers');
	}

	public function remove(Teacher $teacher) {

		$teacher->user->delete();
		$teacher->delete();

		return redirect()
			->route('teachers');
	}

}
