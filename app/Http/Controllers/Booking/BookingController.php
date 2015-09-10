<?php namespace App\Http\Controllers\Booking;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class BookingController extends \App\Http\Controllers\Controller {

	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function index()
	{
		return view('pages.home');
	}

	public function getFormular(){
		return \Input::all();
		$controls = $this->controls();
		return view('pages.form.index')->with(compact('controls'))->render();
	} 

	public function submitGetFormular(){
		$data = Input::all();
		return view('booking.form.index')->with(compact('data'));
	} 

	public function getBookingForm(){
	} 


	public function controls($model = NULL){

		return [
		'email' =>	
			\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
		      ->name('email')->caption('Email')->placeholder('Email')
		      ->class('form-control data-source')
		      ->controlsource('email')->controltype('textbox')
		      ->value($model != NULL ? $model->user->email : '')
		      ->out(),

		];
	}
}
