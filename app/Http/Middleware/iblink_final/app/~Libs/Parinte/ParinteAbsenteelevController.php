<?php namespace Libs;

class ParinteAbsenteelevController extends \Commons\DatatableController
{

	protected $id = 'parinte-absente-elev';

	public function index($id = NULL)
	{
		$id = is_null($id) ? $this->id : $id;
		/**
		 * elevul ca user
		 **/ 
		$student_user     = \App\Models\User::find(\Session::get('student.user.id'));
		/**
		 * elevul ca "student"
		*/
		$student = is_null($student_user) ? NULL : \App\Models\Libs\Elev::find($student_user->userable_id);
		/*
		 * din ce clasa face parte elevul
		 **/
		$clasa = $student->getClasa($this->year->id);
		/**
		 * Ce materii face elevul?
		 **/
		$materii = $student->getMaterii($clasa->id);
		/**
		 * sa vad mediile
		 **/
		$medii = $student->calculeazTotalAbsente($materii, $this->semestres);

		$config = \System\Grids::make($id)->toIndexConfig($id);
		$config['dom'] = '<"dt-container"<"row row-dt-processing"><"row row-dt-toolbar"<"col-xs-12 col-md-6 col-lg-6 dt-tb-left"<"dt-toolbar">><"col-xs-12 col-md-6 col-lg-6 dt-tb-right">><"row row-dt"<"col-xs-12 dt-table"t>>>';


		$config['row-source'] = \URL::route('index-parinte-note-elev-row-sources', ['clasa_id' => $clasa->id, 'id' => $id]);

		$config['caption'] = 'Catalog absenţe | Clasa ' . $clasa->name . ' | <span title="' . $this->semester->start. ' - ' . $this->semester->end . '">Semestrul '  . $this->semester->name . '</span> | ' . $this->year->name;
		return $this->show( $config + ['other-info' => [
			'student_user'           => $student_user,
			'student'                => $student,
			'clasa'                  => $clasa,
			'materii'                => $materii,
			'have_semester_switcher' => false,
			'absente_clasa'            => $medii['absente_clasa'],
			'breadcrumb'             => \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Acasă', 'active' => true],
				['url' => route('index-parinte-note-elev'), 'caption' => 'Note', 'active' => true],
				['url' => '#', 'caption' => 'Absenţe', 'active' => false],
			])
		]]);
	}

	public function rows($clasa_id, $id = NULL)
	{
		$config = \System\Grids::make($id)->toRowDatasetConfig($id);
		$filters = $config['source']->custom_filters();
		$config['source']->custom_filters( $filters + [
			'materiile-mele' => 'subject_teacher_group.group_id = ' . $clasa_id,
		]);
		return $this->dataset( $config  + ['other_infos' => [
			
		]]);
	}


	public function getStudentAbsente()
	{
		return \Response::json(
			\App\Models\Libs\NoteAbsente::getAbsente(\Input::get('class_ids'), \Input::get('semester'))
		);
	}

	public function getAbsenteTotal()
	{
		return \Response::json(
			\App\Models\Libs\NoteAbsente::getAbsenteTotal(
				\Input::get('class_ids'), 
				\Input::get('student_id'),
				\Input::get('clasa_id'),
				$this->semestres
			)
		);
	}
}