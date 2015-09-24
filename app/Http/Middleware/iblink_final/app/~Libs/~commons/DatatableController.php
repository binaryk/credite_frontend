<?php namespace Commons;

class DatatableController extends \System\DatatableController 
{

	public function index($id)
	{
		$this->show( Libs\Grids::make($id)->toIndexConfig($id) + ['other-info' => []]);
	}

	public function rows($id)
	{
		return $this->dataset( Libs\Grids::make($id)->toRowDatasetConfig($id) );
	}

	public function loadForm($id)
	{
		return $this->get_dtform_properties( Libs\Forms::make($id)->toFormConfig($id), \Input::all() );
	}

	public function doAction()
	{
		return $this->do_action( Libs\Forms::make($id = \Input::get('code') )->toActionConfig($id), \Input::all() );
	}
}