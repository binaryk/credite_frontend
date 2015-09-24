<?php namespace App\Http\Controllers;

use App\Services\InvitationSender;
use App\Models\Administrator;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Institution;
use Input;

class AdministratorsController extends Base\BaseController  {

    use ValidatesRequests;

    /** @var Request */
    protected $request;
    protected $inviter;

    public function __construct(Request $request, InvitationSender $inviter) {
        $this->request = $request;
        $this->inviter = $inviter;
    }

    public function index() {

        /** @var Collection|User[] $users */
        $users = Institution::current()
                            ->users()
                            ->where('userable_type', Administrator::getStaticMorphClass())
                            ->orderBy('id')
                            ->get();

        $users->load('userable');

        return view('administrators.index', [
            'users' => $users,
            //'institution' => Institution::current(),
        ]);
    }

    public function add() {
        return view('administrators.add', [
            'institution' => Institution::current(),
        ]);
    }

    public function addPost() {

        $this->validate($this->request, [
            'email'     => 'required|email|unique:users,email',
            'password' => ['required', 'regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            'firstname' => 'required',
            'lastname'  => 'required',
            'cnp'       => 'required|digits:13',
            // no validation needed:
            //'phone'     => '',
            //'address'   => '',
            //'image'     => '',
        ], [
            'email.required'     => 'Introduceți o adresă de email',
            'email.email'        => 'Introduceți o adresă de email validă',
            'email.unique'       => 'Cineva folosește deja această adresa de email',
            'password.required'  => 'Câmpul parolă este obligatoriu',
            'password.confirmed' => 'Parolele introduse nu coincid',
            'password.min'       => 'Parola trebuie să aibă minim 7 caractere',
            'password.regex' => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            'firstname.required' => 'Câmpul nume este obligatoriu',
            'lastname.required'  => 'Câmpul prenume este obligatoriu',
            'cnp.required'       => 'Câmpul CNP este obligatoriu',
            'cnp.digits'         => 'Câmpul CNP nu conține 13 cifre'
        ]);

        $sdata = Input::only(['firstname', 'lastname', 'phone', 'address', 'cnp', 'image']);
        $admin = Administrator::create($sdata);
        $admin->save();

        $user = User::create([
            'email'    => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
            'name'     => implode(' ', Input::only(['firstname', 'lastname'])),
        ]);

        $user->userable_id   = $admin->id;
        $user->userable_type = $admin->getMorphClass();

        $user->save();

        $institution = Institution::current();
        $institution->users()->save($user);

        $this->inviter->emailInvitationLink($user, $institution);

        return redirect()
            ->route('admins');
    }

    public function edit(Administrator $admin) {
        return view('administrators.edit', [
            'institution' => Institution::current(),
            'admin'       => $admin,
        ]);
    }

    public function editPost(Administrator $admin) {

        $this->validate($this->request, [
            'email'     => 'required|email|unique:users,email,' . $admin->user->id,
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

        $sdata = Input::only(['firstname', 'lastname', 'phone', 'address', 'cnp', 'image']);
        $admin->fill($sdata);
        $admin->save();

        $password = Input::get('password');

        if (!empty($password)) {
            $admin->user->password = Hash::make($password);
            $admin->user->save();
        }

        return redirect()
            ->route('admins');
    }

    public function remove(Administrator $admin) {

        $admin->user->delete();
        $admin->delete();

        return redirect()
            ->route('admins');
    }

}
