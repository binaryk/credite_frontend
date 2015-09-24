<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MessagesController extends Base\BaseController  {

	public function index(){
		return view('~admin_panel.messages.index');
	}
	public function compose()
	{
		return view('~admin_panel.messages.compose');
	}

}