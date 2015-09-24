<?php namespace Libs;

class ProfesorClaselemeleController extends \Commons\DatatableController
{

	protected $id = 'profesor-clasele-mele';

	public function index($id = NULL)
	{
		$id = is_null($id) ? $this->id : $id; 
		$config = \System\Grids::make($id)->toIndexConfig($id);		
		$config['caption'] = 'Clasele mele | ' . $this->year->name . ' | Semestrul ' . $this->semester->name;
		$config['dom'] = '<"dt-container"<"row row-dt-processing"><"row row-dt-toolbar"<"col-xs-12 col-md-6 col-lg-6 dt-tb-left"<"dt-toolbar">><"col-xs-12 col-md-6 col-lg-6 dt-tb-right">><"row row-dt"<"col-xs-12 dt-table"t>>>';
		return $this->show( $config + ['other-info' => [
			'have_semester_switcher' => true,
			'breadcrumb'             => \Helper::breadcrumb([
				['url' => \URL::to('/'), 'caption' => 'Acasă', 'active' => true],
				['url' => '#', 'caption' => 'Clasele mele', 'active' => false],
			])
		]]);
	}

	public function rows($id = NULL)
	{
		if( is_null( $this->current_user ) )
		{
			var_dump(\Cookie::get());
			var_dump(\Session::all());
			dd('Nu am user!!!');
		}
		if( is_null($this->institution) )
		{
			dd('Nu am institutie !!!');
		}
		$config = \System\Grids::make($id)->toRowDatasetConfig($id);
		$filters = $config['source']->custom_filters();
		$config['source']->custom_filters( $filters + [
			'my'   => 'subject_teacher_group.user_id = ' . $this->current_user->id,
			'year' => 'groups.year_id = ' . $this->year->id
		]);
		return $this->dataset( $config  + ['other_infos' => [
			
		]]);
	}
}