<?php namespace Libs;
use App\Models\Institution;
use App\Models\Administrator;
use App\Services\InvitationSender; 
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request; 
use Input;
use App\Libs\AdminsRequest;
class AdminsController extends \Commons\DatatableController
{

	protected $id = 'admins-index';
	use ValidatesRequests;

	protected $request;
	protected $inviter;

	public function __construct(Request $request, InvitationSender $inviter) {
	    $this->request = $request;
	    $this->inviter = $inviter;
	}


	public function index($id = NULL)
	{

		$id = is_null($id) ? $this->id : $id; 
		$config = \System\Grids::make($id)->toIndexConfig($id);

		return $this->show( $config + ['other-info' => [ 
			'breadcrumb'             => \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => '#', 'caption' => 'Administratori', 'active' => false],
			]),
			'institution' => Institution::current()
		]]);
	}

	public function rows($id = NULL)
	{
		$id = is_null($id) ? $this->id : $id; 
		$config = \System\Grids::make($id)->toRowDatasetConfig($id);
		$filters = $config['source']->custom_filters();
		$config['source']->custom_filters( $filters);
		return $this->dataset( $config  + ['other_infos' => [
			
		]]);
	}

	public function getAdd()
	{
		$breadcrumb = \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => \URL::to('administrators'), 'caption' => 'Administratori', 'active' => true],
				['url' => '#', 'caption' => 'Adaugă', 'active' => false],
			]);
		$controls = $this->controls();
		$title = "Adaugă administrator";
		$institution = Institution::current();
		 
		$submit = 'admins-add-post'; 
		return view('admins.add')->with(compact('controls','breadcrumb','title','submit','institution'));
	}


	public function postAdd(AdminsRequest $request){

		$request = $request;

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
		    ->route('admins-index');
	}

	

	public function	getEdit($id){ 


		$model = Administrator::find($id);


		// dd($model->user->email);
		$breadcrumb = \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => \URL::to('administrators'), 'caption' => 'Administratori', 'active' => true],
				['url' => '#', 'caption' => 'Editează', 'active' => false],
			]); 

		$controls = $this->controls($model);
		$title = "Editează administrator";
		$institution = Institution::current();
		 
		$submit = 'admins-edit-post'; 
		return view('admins.add')->with(compact('model','controls','breadcrumb','title','submit','institution'));

	}

	public function	postEdit($id){

		$admin = Administrator::find($id);

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
		    ->route('admins-index');


	}

	public function	postRemove($id){
		$admin = Administrator::find($id);
		$admin->user->delete();
		$admin->delete();

		return \Response::json(['message' => "Stergere cu succes."]);
	}

	public function controls($model = NULL){
		return [
		'email' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('email')->caption('Email')->placeholder('Email')
		      ->class('form-control data-source')
		      ->controlsource('email')->controltype('textbox')
		      ->value($model != NULL ? $model->user->email : '')
		      ->out(),
		'password' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.passwordboxes.passwordbox')
		      ->name('password')->caption('Parola')->placeholder('Parola')
		      ->class('form-control data-source')
		      ->controlsource('password')->controltype('password')
		      ->out(),
		'password_confirmation' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.passwordboxes.passwordbox')
		      ->name('password_confirmation')->caption('Confirmă parola')->placeholder('Confirmă parola')
		      ->class('form-control data-source')
		      ->controlsource('password_confirmation')->controltype('textbox')
		      ->out(),
		'firstname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('firstname')->caption('Prenume')->placeholder('Prenume')
		      ->class('form-control data-source')
		      ->controlsource('firstname')->controltype('textbox')
		      ->out(),
		'lastname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('lastname')->caption('Nume')->placeholder('Nume')
		      ->class('form-control data-source')
		      ->controlsource('lastname')->controltype('textbox')
		      ->out(),
		'phone' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('phone')->caption('Telefon')->placeholder('Telefon')
		      ->class('form-control data-source')
		      ->controlsource('phone')->controltype('textbox')
		      ->out(),
		'address' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('address')->caption('Adresă')->placeholder('Adresă')
		      ->class('form-control data-source')
		      ->controlsource('address')->controltype('textbox')
		      ->out(),
		'cnp' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('cnp')->caption('CNP*')->placeholder('CNP*')
		      ->class('form-control data-source')
		      ->controlsource('cnp')->controltype('textbox')
		      ->out(),
		'image' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.fileboxes.imagebox')
		      ->name('image')->caption('Poză')->placeholder('Poză')
		      ->class('form-control data-source')
		      ->controlsource('image')->controltype('textbox')
		      ->out(),
		];	
	}


}