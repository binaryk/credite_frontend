<?php namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;


class BaseController extends Controller 
{

	protected $institution;

	public function __construct()
	{

		$this->institution = \App\Models\Institution::current();
		\View::share('institution', $this->institution);
	}

}