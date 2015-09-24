<?php namespace Libs;

class ProfesorClasaController extends \Commons\DatatableController
{

	protected $id = 'profesor-clasa';

	public function index($clasa_id, $id = NULL)
	{
		$id = is_null($id) ? $this->id : $id; 
		/**
		 * Aflu cine sunt eu ca "teacher"
		 **/
		$teacher = \App\Models\Libs\Profesor::find($this->current_user->userable_id);
		/**
		 * Aflu inregistraea Materie - Profesor - Clasa
		 * Avem posibilitatile:
		 *  	grading_system = grades (NOTE)
		 * 		grading_system = qualificatives (CALIFICATIVE) 
		 *
		 **/
		// dd($clasa_id);
		
		$clasa = \App\Models\Libs\MaterieProfesorClasa::getRecord($clasa_id);	
		$config = \System\Grids::make($id)->toIndexConfig($id);
		$config['dom'] = '<"dt-container"<"row row-dt-processing"><"row row-dt-toolbar"<"col-xs-12 col-md-6 col-lg-6 dt-tb-left"<"dt-toolbar">><"col-xs-12 col-md-6 col-lg-6 dt-tb-right">><"row row-dt"<"col-xs-12 dt-table"t>>>';
		$config['row-source'] = \URL::route('index-profesor-clasa-row-sources', ['clasa_id' => $clasa->group_id, 'id' => $id]);
		$config['caption'] = 'Catalog clasa ' . $clasa->clasa . ' | ' . $clasa->materia . ' | (' . ($clasa->grading_system == 'grades' ? 'NOTE' : 'CALIFICATIVE') . ')'; //'Catalog clasa ' . $clasa->name . ' | ' . $materia->name . ' | ' . $this->year->name . ' | Semestrul ' . $this->semester->name;
		
		return $this->show( $config + ['other-info' => [
			// 'subject_teacher_group' => $subject_teacher_group_record,
			// 'clasa'    => $clasa,
			// 'materia'  => $materia,
			'profesor' => $teacher,
			'materie_profesor_clasa' => $clasa,
			'have_semester_switcher' => false,
		]]);
	}

	public function rows($clasa_id, $id = NULL)
	{
		if( is_null($this->semester) )
		{
			dd('Nu am semestru!');
		}
		$config = \System\Grids::make($id)->toRowDatasetConfig($id);
		$filters = $config['source']->custom_filters();
		$config['source']->custom_filters( $filters + [
			'clasa_id' => 'group_student.group_id = ' . $clasa_id,
		]);
		return $this->dataset( $config  + ['other_infos' => [
			
		]]);
	}

	/**
	 * Modalul pentru notele unei clase
	 **/
	public function getNoteazaClasaForm()
	{
		return \Response::json([
			'title' => 'Notează clasa' . \App\Models\Libs\Noteabsente::TipurinoteToRadio(NULL, \Input::get('grading_system') ),
			'body' => \View::make('~libs.profesor.clasa.modals.noteaza-clasa')->with([
				'elevi' => \Input::get('elevi'),
				'grading_system' => \Input::get('grading_system')
			])->render(),
			'footer' => ''
		]);
	}

	public function insertNoteClasa()
	{
		return \Response::json(\App\Models\Libs\Noteabsente::insertNoteClasa( 
			\Input::get('note'), 
			\Input::get('class_id'),
			\Input::get('grading_system')
		));
	}

	/**
	 *---------------
	 **/
	public function getAbsenteClasaForm()
	{
		return \Response::json([
			'title' => 'Absent clasă',
			'body' => \View::make('~libs.profesor.clasa.modals.absente-clasa')->with([
				'elevi' => \Input::get('elevi')
			])->render(),
			'footer' => ''
		]);
	}

	public function insertAbsenteClasa()
	{
		return \Response::json(\App\Models\Libs\Noteabsente::insertAbsenteClasa( 
			\Input::get('date'), 
			\Input::get('ids'),
			\Input::get('class_id'),
			\Input::get('motivata')
		));
	}

	/**
	 *---------------
	 **/
	public function getMesajeClasaForm()
	{
		return \Response::json([
			'title' => 'Mesaj clasă',
			'body' => \View::make('~libs.profesor.clasa.modals.mesaj-clasa')->with([
				'elevi' => \Input::get('elevi')
			])->render(),
			'footer' => ''
		]);
	}

	public function insertMesajeClasa()
	{
		return \Response::json(\App\Models\Libs\Mesaj::insertMesajeClasa( 
			\Input::get('subiect'), 
			\Input::get('mesaj'),
			\Input::get('ids'),
			\Input::get('class_id'),
			$this->current_user
		));
	}

	/**
	 * Info form
	 **/
	public function getStudentInfoForm()
	{
		$student_id = \Input::get('student_id');
		$student = \App\Models\Libs\Elev::find( $student_id );
		return \Response::json([
			'html' => \View::make('~libs.profesor.clasa.modals.informatii-elev')->with([
				'elev' => $student
			])->render()
		]);
	}

	/**
	 * PLus/Minus activitati
	 **/
	public function saveActivitate()
	{
		$record = \App\Models\Groupstudent::find(\Input::get('id'));
		if($record)
		{
			$record->update([
				\Input::get('coloana') => \Input::get('valoare')
			]);
			return \Response::json(['success' => true]);
		}
		return \Response::json(['success' => false]);
	}

	/**
	 * ABSENTE
	 **/
	public function getStudentAddabsentaForm()
	{
		$student_id = \Input::get('student_id');
		$student = \App\Models\Libs\Elev::find( $student_id );
		return \Response::json([
			'html' => \View::make('~libs.profesor.clasa.modals.add-absenta-elev')->with([
				'elev' => $student
			])->render()
		]);
	}

	public function saveAbsenta()
	{
		\App\Models\Grade::unguard();
		\App\Models\Grade::insert([
			'student_id' => \Input::get('student_id'),
			'class_id'   => \Input::get('clasa_id'),
			'date'       => \Input::get('date'),
			'absent'     => 1,
			'motivated'  => \Input::get('motivated') == 'false' ? 0 : 1
		]);
		return \Response::json(['success' => true]);
	}

	/**
	 * NOTE
	 **/
	public function getStudentAddnotaForm()
	{
		$view = '~libs.profesor.clasa.modals.add-nota-elev-' . \Input::get('grading_system');
		$student_id = \Input::get('student_id');
		$student = \App\Models\Libs\Elev::find( $student_id );
		return \Response::json([
			'html' => \View::make($view)->with([
				'elev' => $student
			])->render()
		]);
	}

	public function saveNota()
	{
		$grade = 
			\Input::get('grading_system') == 'qualificatives' 
			? \App\Models\Grade::toShort(\Input::get('grade'))
			: \Input::get('grade');

		$field = 
			\Input::get('grading_system') == 'qualificatives' 
			? 'calificativ'
			: 'grade';
		\App\Models\Grade::unguard();
		\App\Models\Grade::insert([
			'student_id' => \Input::get('student_id'),
			'class_id'   => \Input::get('clasa_id'),
			'date'       => \Input::get('date'),
			'absent'     => 0,
			$field		 => $grade,
			'grade_type' => \Input::get('grade_type'),
		]);
		return \Response::json(['success' => true]);
	}

	/**
	 * MESAJE
	 **/
	public function getStudentAddmessageForm()
	{
		$student_id = \Input::get('student_id');
		$student = \App\Models\Libs\Elev::find( $student_id );
		return \Response::json([
			'html' => \View::make('~libs.profesor.clasa.modals.add-mesaj-elev')->with([
				'elev' => $student
			])->render()
		]);
	}

	public function saveMesaj()
	{
		$user = \App\Models\User::where('userable_id', \Input::get('student_id'))->where('userable_type', 'student')->get()->first();
    	if($user)
    	{
    		\App\Models\Libs\Mesaj::unguard();
    		\App\Models\Libs\Mesaj::insert([
        		'date' => \Carbon\Carbon::now()->format('Y-m-d'),
        		
        		'user_to'        => $user->id,
        		'userable_to'    => $user->userable_id,
        		'user_type_to'   => $user->userable_type,
        		'user_name_to'   => $user->name,

        		'user_from'      => $this->current_user->id,
        		'userable_from'  => $this->current_user->userable_id,
        		'user_type_from' => $this->current_user->userable_type,
        		'user_name_from' => $this->current_user->name,

        		'subiect' => \Input::get('subiect'),
        		'mesaj'   => \Input::get('mesaj'),

        		'status'  => 'new'

        	]);
        }
        return \Response::json(['success' => true]);
	}

	public function getClasaInformations()
	{
		return \Response::json(
			\App\Models\Libs\Noteabsente::getClasaInformations(
				\Input::get('class_ids'), 
				\Input::get('clasa_id'),
				\Input::get('group_id'),
				$this->semester,
				$this->semestres,
				\Input::get('grading_system')
			)
		);
	}

}