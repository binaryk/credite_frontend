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
		$data['caption'] = 'BOOKING DETAILS FORM';
		$data['steps'] = $this->steps();

		return view('booking.form.index')->with(compact('data'));
	} 

	public function getBookingForm(){
	} 

	public function steps(){
	return $steps = [
		'records' => $this->controls(),
		'tabs' => [
			[
				'caption' => 'Journey details',
				'help'    => 'Provide journey details',
				'view'    => '1',
			],
			[
				'caption' => 'Your details',
				'help'    => 'Provide your details',
				'view'    => '2'
			],
			[
				'caption' => 'Confirm',
				'help'    => '',
				'view'    => '3'
			]
		]

	];
	}


	public function controls($model = NULL){

		return [
			'email' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('email')->caption('Email')
			      // ->placeholder('Email')
			      ->class('form-control data-source')
			      ->controlsource('email')->controltype('textbox')
			      ->value($model != NULL ? $model->user->email : '')
			      ->out(),
			'name' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('name')->caption('Name')
			      ->class('form-control data-source')
			      ->controlsource('name')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('phone')->caption('Phone')
			      ->class('form-control data-source')
			      ->controlsource('phone')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'resident_phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('resident_phone')->caption('Resident phone')
			      ->class('form-control data-source')
			      ->controlsource('resident_phone')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from')->caption('From')
			      ->class('form-control data-source')
			      ->controlsource('from')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'from_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from_nr')->caption('From door no')
			      ->class('form-control data-source')
			      ->controlsource('from_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'to' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to')->caption('To')
			      ->class('form-control data-source')
			      ->controlsource('to')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'to_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_nr')->caption('To door no')
			      ->class('form-control data-source')
			      ->controlsource('to_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'to_street' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_street')->caption('To street	')
			      ->class('form-control data-source')
			      ->controlsource('to_street')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),  
			'up_date' =>	     
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
				->name('up_date')
				->caption('Pick up date')
				->class('form-control calendar data-source')->readonly(0)
				->controlsource( 'up_date')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
				->out(),
	     	'nr_passegers' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('nr_passegers')
	            ->caption('No of passengers')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource( 'nr_passegers')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(['1' => '1', '2' => '2','3' => '3','4' => '4'])
	            ->out(),
	     	'nr_luggages' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('nr_luggages')
	            ->caption('No of luggages')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource( 'nr_luggages')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(['1' => '1', '2' => '2'])
	            ->out(),
	     	'nr_hand_luggages' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('nr_hand_luggages')
	            ->caption('No of hand luggages')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource( 'nr_hand_luggages')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(['1' => '1', '2' => '2'])
	            ->out(), 
			'details' => 
				\Easy\Form\Editbox::make('~layouts.form.controls.editboxes.editbox')
				->name('details')
				->caption('Special Requirement')
				->controlsource('Special Requirement')
				->controltype('editbox')
				->class('form-control input-sm data-source')
				->out()

			];
	}
 
}
