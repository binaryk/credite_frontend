<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	public function welcome()
	{
		

		return view('pages.welcome');
	}

	public function about()
	{
		$breadcrumbs = [
            [
                'name' => 'About',
                'url'  => "",
                'ids' => ''
            ]
        ];

		return view('pages.about')->with(compact('breadcrumbs'));
	}

	public function contact()
	{
		return view('pages.contact');
	}

}
