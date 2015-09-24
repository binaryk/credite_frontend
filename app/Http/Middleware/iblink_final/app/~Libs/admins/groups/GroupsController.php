<?php namespace Libs;
use App\Models\Institution;
use App\Models\Group;
use App\Models\Teacher;
use App\Services\InvitationSender; 
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request; 
use Input;
use App\Libs\GroupsRequest;
class GroupsController extends \Commons\DatatableController
{

	protected $id = 'groups-index';
	use ValidatesRequests;

	protected $request;
	protected $inviter;
	protected $bread; 
	protected $teachers = []; 
	protected $letters = []; 

	public function __construct(Request $request, InvitationSender $inviter) {
	    $this->request = $request;
	    $this->inviter = $inviter;
        $this->bread   = \Helper::breadcrumb([
    			['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
    			['url' => \URL::to('groups-index'), 'caption' => 'Clase', 'active' => true],
    			
    		]); 

      	$this->teachers = Institution::current()->users()
		                        ->where('userable_type', Teacher::getStaticMorphClass())
		                        ->get();
        $teachers = [];
        foreach ($this->teachers as $key => $teacher) {
        	$teachers[$teacher->id] = $teacher->name;
        }
        $this->teachers = $teachers;
        $letters = [];
        foreach (range('A', 'Z') as $key => $letter) {
        	$letters[$letter] = $letter;
        }
        $this->letters = $letters;
	}


	public function index($id = NULL)
	{

		$id = is_null($id) ? $this->id : $id; 
		$config = \System\Grids::make($id)->toIndexConfig($id);

		return $this->show( $config + ['other-info' => [ 
			'breadcrumb'             => $this->bread,
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
    			['url' => \URL::to('groups-index'), 'caption' => 'Clase', 'active' => true],
    			['url' => '#', 'caption' => 'Adaugă', 'active' => false]
    			
    		]);  

		$controls = $this->controls(); 



		$title = "Adaugă clasă";
		$institution = Institution::current();
		$submit = 'groups-add-post'; 
		return view('~admin_panel.groups.add')->with(compact('controls','breadcrumb','title','submit','institution'));
	}


	public function postAdd(){

		 $this->validate($this->request, [
            'master_id' => 'exists:users,id,userable_type,teacher',
            'num'       => 'required',
            'letter'    => 'required',
        ], [
            'num.required'    => 'Nu aÈ›i selectat clasa',
            'letter.required' => 'Nu aÈ›i selectat litera',
        ]);

        $group = new Group(Input::all());

        $institution = Institution::current();
        $semester    = $institution->semester;
        $year        = $semester->year;

        $group->institution_id = $institution->id;
        $group->year_id        = $year->id;

        $group->selfRename();
        $group->save();

		return redirect()
		    ->route('groups-index');
	}

	public function getStudents(){

		$group_id = \Input::get('group_id');
		$students = \App\Models\Group::find( $group_id )->students();

		return \Response::json([
			'html' => \View::make('~admin_panel.groups.students.index')->with([
				'students' => $students
			])->render()
		]); 
	}


	public function postStudents($id){

	}

	public function getSubjects($id){

	}

	public function postSubjects($id){

	}


	public function	getEdit($id){ 

		$breadcrumb = \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Management', 'active' => true],
				['url' => \URL::to('groups-index'), 'caption' => 'Clase', 'active' => true],
				['url' => '#', 'caption' => 'Editează', 'active' => false]
		]);  
		$model = Group::find($id);
		$controls = $this->controls($model); 

		$title = "Editează clasă";
		$institution = Institution::current();
		$submit = 'groups-edit-post'; 
		return view('~admin_panel.groups.add')->with(compact('controls','model','breadcrumb','title','submit','institution'));

	}

	public function	postEdit($id){

		$group = Group::find($id);

		  $this->validate($this->request, [
            'master_id' => 'exists:users,id,userable_type,teacher',
            'num'       => 'required',
            'letter'    => 'required',
        ], [
            'num.required'    => 'Nu aÈ›i selectat clasa',
            'letter.required' => 'Nu aÈ›i selectat litera',
        ]);

        $group->fill(Input::except(['name']));

        $group->selfRename();
        $group->save();

		return redirect()
		    ->route('groups-index');


	}

	public function	postRemove($id){
		$group = Group::find($id);
        $group->delete();
        return \Response::json(['message' => 'Stergere cu succes']); 
	}

	public function controls($model = NULL){
		return [
			'num' =>	
				\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
	            ->name('num')
	            ->caption('Nume grupa/cls:')
	            ->class('form-control data-source input-group form-select init-on-update-delete')
	            ->controlsource('num')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->value($model ? $model->num : -1)
	            ->options(['-1' => "- Selectează -"] + Group::getRomanNumbers())
			     ->out(),
			'master_id' =>	
				\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
	            ->name('master_id')
	            ->caption('Nume educator:')
	            ->class('form-control data-source input-group form-select init-on-update-delete')
	            ->controlsource('master_id')
	            ->controltype('combobox') 
	            ->enabled('false') 
	            ->value($model ? $model->master_id : -1)
	            ->options(['-1' => "- Selectează -"]  + $this->teachers )
			     ->out(),
			'letter' =>	
				\Easy\Form\Combobox::make('~libs.~layouts.form.controls.comboboxes.combobox')
	            ->name('letter')
	            ->caption('Literă:')
	            ->class('form-control data-source input-group form-select init-on-update-delete')
	            ->controlsource('letter')
	            ->controltype('combobox') 
	            ->enabled('false') 
	            ->value($model ? $model->letter : -1)
	            ->options(['-1' => "- Selectează -"] + $this->letters)
			     ->out(),
		];	
	}


}