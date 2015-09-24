<?php namespace Libs;
use App\Models\Institution;
use App\Models\Teacher;
use App\Models\Country;
use App\Models\Tara;
use App\Services\InvitationSender; 
use App\Models\User;
use App\Models\Nationalitate;
use App\Models\Judet;
use App\Models\Localitate;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request; 
use Input;
use App\Libs\TeacherRequest;
class TeachersController extends \Commons\DatatableController
{

	protected $id = 'teachers-index';
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
				['url' => '#', 'caption' => 'Profesori/Învățători', 'active' => false],
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
				['url' => \URL::to('teachers-index'), 'caption' => 'Profesori/Învățători', 'active' => true],
				['url' => '#', 'caption' => 'Adaugă', 'active' => false],
			]);
		$controls = $this->controls();
		$title = "Adaugă profesor";
		$institution = Institution::current();
		 
		$submit = 'teachers-add-post'; 
		return view('~admin_panel.teachers.add')->with(compact('controls','breadcrumb','title','submit','institution'));
	}


	public function postAdd(TeacherRequest $request){

		$tdata = Input::all();
		$request = $request;
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
			->route('teachers-index');    ;
	}


	public function	getEdit($id){ 


		$model = Teacher::find($id);
		$breadcrumb = \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => \URL::to('teachers-index'), 'caption' => 'Profesori/Învățători', 'active' => true],
				['url' => '#', 'caption' => 'Editează', 'active' => false],
			]); 

		$controls = $this->controls($model); 

		$title = "Editează profesor";
		$institution = Institution::current();
		$submit = 'teachers-edit-post'; 
		return view('~admin_panel.teachers.add')->with(compact('model','controls','breadcrumb','title','submit','institution'));

	}

	public function	postEdit($id){

		$teacher = Teacher::find($id);

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
		    ->route('teachers-index');


	}

	public function	postRemove($id){
		$teacher = Teacher::find($id);
		$teacher->user->delete();
		$teacher->delete();

		return \Response::json(['message' => "Stergere cu succes."]);
	}

	public function controls($model = NULL){
		return [
		'position' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('position')
            ->caption('Funcția')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('position')
            ->controltype('combobox') 
            ->enabled('false') 
            ->options(['' => "- Selectează -"] + Teacher::positions())
		     ->out(),
     	'disciplina' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('disciplina')->caption('Disciplina')->placeholder('Disciplina')
		      ->class('form-control input-large data-source')
		      ->controlsource('disciplina')->controltype('textbox')
		      ->out(),
		'studies' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('studies')
            ->caption('Nivel studii')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('studies')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Teacher::studies())
            ->out(), 
		'lead' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('lead')
            ->caption('Funcție de conducere')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('lead')
            ->controltype('combobox') 
            ->enabled('false')
            ->options( ['' => '- Selectează -'] + ['yes' => 'Da', 'no' => 'Nu'])
		     ->out(),
     	'spec' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('spec')->caption('Specializare obținută în urma finalizării studiilor')->placeholder('Specializare obținută în urma finalizării studiilor')
		      ->class('form-control input-large data-source')
		      ->controlsource('spec')->controltype('textbox')
		     ->out(),
		'graduated_on' =>	     
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox-addon')
			->name('graduated_on')->caption('Data terminării studii')->placeholder('Data terminării studii')
			->class('form-control input-large date data-source')->readonly(1)
			->controlsource('graduated_on')->controltype('textbox')
			->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
			->out(),
		'degree' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('degree')
            ->caption('Grad didactic')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('degree')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Teacher::grad())
            ->out(),
		'last_development_type' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('last_development_type')
            ->caption('Tipul ultimei perfectionări *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('last_development_type')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Teacher::development())
            ->out(),
     	'foreign_langs' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('foreign_langs')->caption('Limbi străine cunoscute *')->placeholder('Limbi străine cunoscute *')
		      ->class('form-control input-large data-source')
		      ->controlsource('foreign_langs')->controltype('textbox')
		     ->out(),
		'employment_type' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('employment_type')
            ->caption('Mod încadrare *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('employment_type')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Teacher::getEmploymentTypes())
            ->out(),
         // nu exista
     	'nr_act_incadrare' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('nr_act_incadrare')->caption('Număr act încadrare *')->placeholder('Număr act încadrare *')
		      ->class('form-control input-large data-source')
		      ->controlsource('nr_act_incadrare')->controltype('textbox')
		     ->out(),
         // nu exista
		'data_incadrare' =>	     
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox-addon')
			->name('data_incadrare')->caption('Data act încadrare')->placeholder('Data act încadrare')
			->class('form-control input-large date data-source')->readonly(1)
			->controlsource('data_incadrare')->controltype('textbox')
			->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
			->out(),
     	'maiden_name' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('maiden_name')->caption('Nume familie la naștere *')->placeholder('Nume familie la naștere *')
		      ->class('form-control input-large data-source')
		      ->controlsource('maiden_name')->controltype('textbox')
		     ->out(), 
		// nu exista
     	'nume_familie_actual' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('nume_familie_actual')->caption('Nume de familie actual *')->placeholder('Nume de familie actual *')
		      ->class('form-control input-large data-source')
		      ->controlsource('nume_familie_actual')->controltype('textbox')
		     ->out(), 
     	'phone' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('phone')->caption('Telefon *')->placeholder('Telefon *')
		      ->class('form-control input-large data-source')
		      ->controlsource('phone')->controltype('textbox')
		     ->out(),
     	'cnp' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('cnp')->caption('CNP *')->placeholder('CNP *')
		      ->class('form-control input-large data-source')
		      ->controlsource('cnp')->controltype('textbox')
		     ->out(), 
  		'country_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('country_id')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('country_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(), 
		'dob' =>	     
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox-addon')
			->name('dob')->caption('Data nașterii')->placeholder('Data nașterii')
			->class('form-control input-large date data-source')->readonly(1)
			->controlsource('dob')->controltype('textbox')
			->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
			->out(), 
		// nu exista
  		'country_born_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('country_born_id')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('country_born_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(),
		// nu exista
  		'nationalitate' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('nationalitate')
            ->caption('Naționalitate *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('nationalitate')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Nationalitate::toCombo())
            ->out(),
		// nu exista
  		'country_address_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('country_address_id')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('country_address_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(),
		// nu exista
  		'judet_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('judet_id')
            ->caption('Județ *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('judet_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Judet::toCombobox())
            ->out(),
		// nu exista
  		'localitate_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('localitate_id')
            ->caption('Localitate *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('localitate_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Localitate::toCombobox())
            ->out(),
        // nu exista
     	'strada' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('strada')->caption('Stradă')->placeholder('Stradă')
		      ->class('form-control input-large data-source')
		      ->controlsource('strada')->controltype('textbox')
		     ->out(),
        // nu exista
     	'numar_str' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('numar_str')->caption('Număr:')->placeholder('Număr:')
		      ->class('form-control input-large data-source')
		      ->controlsource('numar_str')->controltype('textbox')
		     ->out(),
        // nu exista
     	'bloc' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('bloc')->caption('Bloc:')->placeholder('Bloc:')
		      ->class('form-control input-large data-source')
		      ->controlsource('bloc')->controltype('textbox')
		     ->out(),
        // nu exista
     	'scara' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('scara')->caption('Scară:')->placeholder('Scară:')
		      ->class('form-control input-large data-source')
		      ->controlsource('scara')->controltype('textbox')
		     ->out(),
        // nu exista
     	'etaj' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('etaj')->caption('Etaj:')->placeholder('Etaj:')
		      ->class('form-control input-large data-source')
		      ->controlsource('etaj')->controltype('textbox')
		     ->out(),
        // nu exista
     	'apartament' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('apartament')->caption('Apartament:')->placeholder('Apartament:')
		      ->class('form-control input-large data-source')
		      ->controlsource('apartament')->controltype('textbox')
		     ->out(),
        // nu exista
     	'cod_postal' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('cod_postal')->caption('Cod postal:')->placeholder('Cod postal:')
		      ->class('form-control input-large data-source')
		      ->controlsource('cod_postal')->controltype('textbox')
		     ->out(),
        // nu exista
     	'alta_localitate' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('alta_localitate')->caption('Altă localitate:')->placeholder('Altă localitate:')
		      ->class('form-control input-large data-source')
		      ->controlsource('alta_localitate')->controltype('textbox')
		     ->out(),
        // nu exista
     	'alt_judet' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('alt_judet')->caption('Alt județ / Altă regiune:')->placeholder('Alt județ / Altă regiune:')
		      ->class('form-control input-large data-source')
		      ->controlsource('alt_judet')->controltype('textbox')
		     ->out(),
     	'email' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('email')->caption('Email*:')->placeholder('Email*:')
		      ->class('form-control input-large data-source')
		      ->value($model != NULL ? $model->user->email : '')
		      ->controlsource('email')->controltype('textbox')
		     ->out(),
     	'firstname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('firstname')->caption('Prenume*:')->placeholder('Prenume*:')
		      ->class('form-control input-large data-source') 
		      ->controlsource('firstname')->controltype('textbox')
		     ->out(),
     	'lastname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('lastname')->caption('Nume*:')->placeholder('Nume*:')
		      ->class('form-control input-large data-source') 
		      ->controlsource('lastname')->controltype('textbox')
		     ->out(),
		'password' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.passwordboxes.passwordbox')
		      ->name('password')->caption('Parola*')->placeholder('Parola*')
		      ->class('form-control input-large data-source')
		      ->controlsource('password')->controltype('password')
		      ->out(),
		'password_confirmation' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.passwordboxes.passwordbox')
		      ->name('password_confirmation')->caption('Confirmare parolă*')->placeholder('Confirmare parolă*')
		      ->class('form-control input-large data-source')
		      ->controlsource('password_confirmation')->controltype('password')
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