<?php namespace App\Http\Controllers;

use App\Models\Airport; 
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

	public function __construct()
	{
	}

	public function index()
	{
		return view('pages.home');
	}

	public function getAirports(){
		$airports = Airport::all();
		return \Response::json(['airports' => $airports]);
	} 

}