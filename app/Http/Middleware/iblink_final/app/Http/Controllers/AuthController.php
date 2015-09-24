<?php namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\User;
use Hash;
use Illuminate\Auth\Guard;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Input;
use Session;
use Auth;

class AuthController extends Base\BaseController  
{

    use ResetsPasswords;

    protected $subject = 'Resetare parolă pe iBlink.ro';
    protected $redirectPath = '/';

    public function __construct(Guard $auth, PasswordBroker $passwords) {
        $this->auth      = $auth;
        $this->passwords = $passwords;
    }

    public function login() 
    {
        return view('auth.login');
    }

    public function postLogin(Request $request) 
    {
        $input = Input::only(['email', 'password']);
        if ($this->auth->attempt($input, true)) 
        {
            return redirect()->intended(route('dashboard'));
        }
        // bogus session expiration fix
        // http://stackoverflow.com/a/279387/539153
        if ( ($rememeber = $request->get('remember')) && ($hashmethod = $request->get('hashtype')) )
        {
            $input['password'] = $hashmethod($rememeber);
            if ($this->auth->attempt($input, true)) 
            {
                return redirect()->intended(route('dashboard'));
            }
        }
        return redirect()->route('auth.login')->withErrors(['Utilizator sau parolă incorecte']);
    }

    public function logout() 
    {
        $this->auth->logout();
        Session::remove('institution.id');
        return redirect()->route('dashboard');
    }

    protected function getSwitcherItems(User $user) {

        $items = new Collection();

        if ($user->getOriginal('userable_type') == 'custodian') {

            foreach ($user->userable->students as $studentUser) {
                $items->put($studentUser->id, [
                    'id'    => $studentUser->id,
                    'name'  => $studentUser->name,
                    'image' => $studentUser->userable->image,
                ]);
            }

            return $items;
        }

        foreach ($user->institutions as $institution) {
            $items->put($institution->id, [
                'id'    => $institution->id,
                'name'  => $institution->name,
                'image' => $institution->image,
            ]);
        }

        return $items;
    }

    public function switcher() 
    {
        if( is_null($user  = \Auth::user()) )
        {
            return \Redirect::to('auth/login');
        }
        return view('auth.switcher', ['items' => $this->getSwitcherItems($user)]);
    }

    public function postSwitcher() 
    {
        if( is_null($user  = \Auth::user()) )
        {
            return \Redirect::to('auth/login');
        }   
        $items = $this->getSwitcherItems($user);
        if (!$items->has($id = Input::input('item_id'))) 
        {
            return redirect()->route('auth.login');
        }
        if ($user->getOriginal('userable_type') != 'custodian') 
        {
            Session::put('institution.id', $id);
            return redirect()->intended(route('dashboard'));;
        }
        $studentUser = User::find($id);
        $institution = $studentUser->institutions()->first();
        Session::put('institution.id', $institution->id);
        Session::put('student.user.id', $studentUser->id);
        return redirect()->intended(route('dashboard'));;
    }

    public function postReset(Request $request) {

        $this->validate($request, [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
        ], [
            'email.required'     => 'Câmpul email este obligatoriu',
            'email.email'        => 'Nu ați introdus un email valid',
            'password.required'  => 'Câmpul parolă este obligatoriu',
            'password.confirmed' => 'Parolele introduse nu coincid',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
            $this->auth->login($user, true);
        });

        if ($response == PasswordBroker::PASSWORD_RESET) {
            return redirect($this->redirectPath());
        }

        return redirect()->back()
                         ->withInput($request->only('email'))
                         ->withErrors(['email' => trans($response)]);
    }
}
