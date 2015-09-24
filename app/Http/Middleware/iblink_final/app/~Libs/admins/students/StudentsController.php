<?php namespace Libs;
use App\Models\Institution;
use App\Models\Student;
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
use App\Libs\StudentsRequest;
class StudentsController extends \Commons\DatatableController
{

	protected $id = 'students-index';
	use ValidatesRequests;

	protected $request;
	protected $inviter;
	protected $bread; 

	public function __construct(Request $request, InvitationSender $inviter) {
	    $this->request = $request;
	    $this->inviter = $inviter;
	    $this->bread   = \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => \URL::to('students-index'), 'caption' => 'Copii', 'active' => true],
				['url' => '#', 'caption' => 'Adaugă', 'active' => false],
			]);
	}


	public function index($id = NULL)
	{
		$id = is_null($id) ? $this->id : $id; 
		$config = \System\Grids::make($id)->toIndexConfig($id);

		return $this->show( $config + ['other-info' => [ 
			'breadcrumb'             => \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => '#', 'caption' => 'Copii', 'active' => false],
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
		$breadcrumb = $this->bread;
		$controls = $this->controls();
		$title = "Adaugă elev";
		$institution = Institution::current();
		 
		$submit = 'students-add-post'; 
		return view('~admin_panel.students.add')->with(compact('controls','breadcrumb','title','submit','institution'));
	}


	public function postAdd(StudentsRequest $request){
 
		$request = $request;
		$tfields = [
            'lastname', 'parents_initials', 'firstname', 'gender',
            'dob', 'cnp', 'nationality', 'emergency_name', 'emergency_phone',
            'secondary_emergency_name', 'secondary_emergency_phone',
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
			->route('students-index');    ;
	}


	public function	getEdit($id){ 

		$model = Student::find($id);
		$breadcrumb = $this->bread;
		$controls = $this->controls($model); 
		$title = "Editează elev";
		$institution = Institution::current();
		$submit = 'students-edit-post'; 
		return view('~admin_panel.students.add')->with(compact('model','controls','breadcrumb','title','submit','institution'));

	}

	public function	postEdit($id){

		$student = Student::find($id);

		$this->validate($this->request, [
            'email'                     => 'required|email|unique:users,email,' . $student->user->id,
            'password'                  => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            'firstname'                 => 'required',
            'lastname'                  => 'required',
            'dob'                       => 'required',
            'cnp'                       => 'required|digits:13',
            "parents_initials"          => "required",
            // "gender"                    => "in:,
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
		    ->route('students-index');


	}

	public function	postRemove($id){
		$teacher = Student::find($id);
		$teacher->user->delete();
		$teacher->delete(); 
		return \Response::json(['message' => "Stergere cu succes."]);
	}

	/*Custodians*/ 


	/*Custodians*/

	public function controls($model = NULL){
		return [
     	'lastname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('lastname')->caption('Nume familie*')->placeholder('Nume familie*')
		      ->class('form-control input-large data-source')
		      ->controlsource('lastname')->controltype('textbox')
		     ->out(), 
     	'parents_initials' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('parents_initials')->caption('Nume familie la naștere *')->placeholder('Nume familie la naștere *')
		      ->class('form-control input-large data-source')
		      ->controlsource('parents_initials')->controltype('textbox')
		     ->out(), 
     	'firstname' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('firstname')->caption('Prenume *')->placeholder('Prenume *')
		      ->class('form-control input-large data-source')
		      ->controlsource('firstname')->controltype('textbox')
		     ->out(), 
     	'gender' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('gender')
            ->caption('Sex *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('gender')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Student::getGenders())
            ->out(), 
		'dob' =>	     
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox-addon')
			->name('dob')->caption('Data nașterii')->placeholder('Data nașterii')
			->class('form-control date input-large data-source')->readonly(1)
			->controlsource('dob')->controltype('textbox')
			->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
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
  		'county_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('county_id')
            ->caption('Județ *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('county_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Judet::toCombobox())
            ->out(),
  		'nationality' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('nationality')
            ->caption('Naționalitate *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('nationality')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Nationalitate::toCombo())
            ->out(), 
        // nu exista
     	'alta_localitate' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('alta_localitate')->caption('Altă localitate:')->placeholder('Altă localitate:')
		      ->class('form-control input-large data-source')
		      ->controlsource('alta_localitate')->controltype('textbox')
		     ->out(), 
		'language' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('language')
            ->caption('Limba maternă')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('language')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['romanian' => 'Română','english'  => 'Engleză','finnish'  => 'Finlandeză','turca'  => 'Turcă'])
            ->out(),
        // nu exista 
		'religie' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('religie')
            ->caption('Religie')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('religie')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['orto' => 'Ortodox','cat'  => 'Catolic','prot'  => 'Protestant','mus'  => 'Musulman'])
            ->out(),
  		'address_country_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('address_country_id')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('address_country_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(),
  		'address_county_id' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('address_county_id')
            ->caption('Județ *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('address_county_id')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Judet::toCombobox())
            ->out(),
        // nu exista
  		'tara_suplimentara' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('tara_suplimentara')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('tara_suplimentara')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(),
     	'cnp' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('cnp')->caption('CNP *')->placeholder('CNP *')
		      ->class('form-control input-large data-source')
		      ->controlsource('cnp')->controltype('textbox')
		     ->out(),
     	'emergency_name' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('emergency_name')->caption('Nume și prenume în caz de urgență*')->placeholder('Nume și prenume în caz de urgență*')
		      ->class('form-control input-large data-source')
		      ->controlsource('emergency_name')->controltype('textbox')
		     ->out(), 
     	'secondary_emergency_name' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('secondary_emergency_name')->caption('Nume și prenume secundar în caz de urgență:*')->placeholder('Nume și prenume secundar în caz de urgență:*')
		      ->class('form-control input-large data-source')
		      ->controlsource('secondary_emergency_name')->controltype('textbox')
		     ->out(), 
     	'emergency_phone' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('emergency_phone')->caption('Telefon în caz de urgență*:')->placeholder('Telefon în caz de urgență*:')
		      ->class('form-control input-large data-source')
		      ->controlsource('emergency_phone')->controltype('textbox')
		     ->out(),
     	'secondary_emergency_phone' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('secondary_emergency_phone')->caption('Telefon secundar în caz de urgență*')->placeholder('Telefon secundar în caz de urgență*')
		      ->class('form-control input-large data-source')
		      ->controlsource('secondary_emergency_phone')->controltype('textbox')
		     ->out(),
        // nu exista
  		'taxa' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('taxa')
            ->caption('Mă oblig să plătesc taxa de școlarizare până la data stabilită în contract: *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('taxa')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'disponibil_contactat' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('disponibil_contactat')
            ->caption('În situația în care nu pot fi contactat(ă) în caz de urgență autorizez personalul grădiniței să aplice măsurile de securitate în beneficiul copilului :')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('disponibil_contactat')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'autorizez_masuri' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('autorizez_masuri')
            ->caption('Autorizez personalul grădiniței să întreprindă măsurile de prim ajutor în caz de urgență:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('autorize_masuriz')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'autorizez_poze' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('autorizez_poze')
            ->caption('Autorizez grădinița să folosească pozele din timpul anului școlar promovării grădiniței (site, pliante):')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('autorizez_poze')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'autorizez_participarea' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('autorizez_participarea')
            ->caption('Autorizez participarea copilului meu în activitățile grădiniței anunțate în prealabil și iau la cunoștință procedurile de desfășurare a acestora:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('autorizez_participarea')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'autorizez_efectuarea_orelor' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('autorizez_efectuarea_orelor')
            ->caption('Autorizez efectuarea orelor de recuperare cu copilul meu, daca profesorul considera necesar, în limita programului zilnic, fiind anunțat în prealabil:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('autorizez_efectuarea_orelor')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'dizabilitati' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('dizabilitati')
            ->caption('Copilul prezintă o formă de dizabilitate psihică sau fizică:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('dizabilitati')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
		'detalii_dizabilitati' =>
			\Easy\Form\Editbox::make('~libs.~layouts.form.controls.editboxes.editbox')
			->name('detalii_dizabilitati')
			->caption('Detalii dizabilitate:') 
			->controlsource('detalii_dizabilitati')
			->controltype('editbox')
			->class('form-control input-sm data-source')
			->out(),
        // nu exista
  		'alergie' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('alergie')
            ->caption('Copilul are anumite alergii la mâncare sau medicamente :')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('alergie')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
		'detalii_alergii' =>
			\Easy\Form\Editbox::make('~libs.~layouts.form.controls.editboxes.editbox')
			->name('detalii_alergii')
			->caption('Detalii alergii:') 
			->controlsource('detalii_alergii')
			->controltype('editbox')
			->class('form-control input-sm data-source')
			->out(),
        // nu exista
        'jucarii_preferate' =>    
            \Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
              ->name('jucarii_preferate')->caption('Jucarii preferate')->placeholder('Jucarii preferate')
              ->class('form-control input-large data-source')
              ->controlsource('jucarii_preferate')->controltype('textbox')
             ->out(),
        // nu exista
     	'alte_jocuri' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('alte_jocuri')->caption('Alte jocuri și jucării preferate:*')->placeholder('Alte jocuri și jucării preferate:*')
		      ->class('form-control input-large data-source')
		      ->controlsource('alte_jocuri')->controltype('textbox')
		     ->out(),
        // nu exista
  		'primesc_mailuri' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('primesc_mailuri')
            ->caption('Doresc sa primesc pe mailul specificat mesaje și comunicate importante legate de activitatea educaționala :')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('primesc_mailuri')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'informare_mai_buna' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('informare_mai_buna')
            ->caption('Doresc o mai bună informare asupra facilităților existente în spațiul educațional:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('informare_mai_buna')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'primesc_mesaje_mail' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('primesc_mesaje_mail')
            ->caption('Sunt de acord ca mesajele ce sunt primite pe adresa de mail personală să conțină sondaje și inserții publicitare pentr a ne permite să perfecționam publicitatea educațională:')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('primesc_mesaje_mail')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + ['1' => 'Da', '2' => 'Nu'])
            ->out(),
        // nu exista
  		'country_alta_institutie' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('country_alta_institutie')
            ->caption('Țara *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('country_alta_institutie')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Tara::toCombobox())
            ->out(),
        // nu exista
  		'county_alta_institutie' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('county_alta_institutie')
            ->caption('Județ *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('county_alta_institutie')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Judet::toCombobox())
            ->out(),
        // nu exista
  		'localitate_alta_institutie' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('localitate_alta_institutie')
            ->caption('Localitate/Sector *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('localitate_alta_institutie')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + Localitate::toCombobox())
            ->out(),
         // nu exista
      	'institutie' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('institutie')->caption('Instituție*')->placeholder('Instituție*')
		      ->class('form-control input-large data-source')
		      ->controlsource('institutie')->controltype('textbox')
		     ->out(),
        // nu exista
  		'tip_finantare' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('tip_finantare')
            ->caption('Tip finanțare *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('tip_finantare')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + [])
            ->out(),
        // nu exista
  		'tip_program' =>	
			\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
            ->name('tip_program')
            ->caption('Tip program *')
            ->class('form-control input-large data-source input-group form-select init-on-update-delete')
            ->controlsource('tip_program')
            ->controltype('combobox') 
            ->enabled('false')
            ->options(['' => '- Selectează -'] + [])
            ->out(),
         // nu exista
      	'ani_promovati' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('ani_promovati')->caption('Anii de studii promovați')->placeholder('Anii de studii promovați')
		      ->class('form-control input-large data-source')
		      ->controlsource('ani_promovati')->controltype('textbox')
		     ->out(),
         // nu exista
      	'bursa' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('bursa')->caption('Am primit bursă timp de (ani) fost înscris :')->placeholder('Am primit bursă timp de (ani) fost înscris :')
		      ->class('form-control input-large data-source')
		      ->controlsource('bursa')->controltype('textbox')
		     ->out(),
     	'email' =>	
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('email')->caption('Email*:')->placeholder('Email*:')
		      ->class('form-control input-large data-source')
		      ->value($model != NULL ? $model->user->email : '')
		      ->controlsource('email')->controltype('textbox')
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
		      ->class('form-control input-large data-source')
		      ->controlsource('image')->controltype('textbox')
		      ->out(),
      ];	
	}


}