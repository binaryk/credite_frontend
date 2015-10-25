<?php namespace App\Http\Controllers\BookingFull;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;

class BookingFullController extends PreBookingFullController {

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

	public function postForm(){
		$data = Input::get('data');
    	$user = $this->createUser($data);
    	if($user){
    		$data['user_id'] = $user->id;
    		$this->saveBook($data);
    	}
	} 

	public function destination($quick){
		$data['caption'] = 'BOOKING DETAILS FORM';
		$data['steps'] = $this->steps($quick);
		return $data;
		

	}
    /*action*/
    public function onlinePay()
    { 
         
    }

    public function submitBookingPrev(){
    	$data = Input::all();
    	$data = $this->destination($data);
    	return view('booking.form.index')->with(compact('data'));

    } 

	public function steps($quick = NULL){
	return $steps = [
		'records' => $this->controls($quick),
		'tabs' => [
			[
				'caption' => 'Details',
				'help'    => 'Provide details',
				'view'    => '1',
			],
			[
				'caption' => 'Pickup date/time',
				'help'    => 'Provide pickup date/time',
				'view'    => '2'
			]
		]

	];
	}


	public function controls($quick = NULL, $model = NULL){
		return [
			'email' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('email')->caption('Email')
			      ->ng_model('form.email')
			      // ->placeholder('Email')
			      ->class('form-control data-source')
			      ->controlsource('email')->controltype('textbox')
			      ->value($model != NULL ? $model->user->email : '')
			      ->out(),
			'name' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('name')->caption('Name')
			      ->ng_model('form.name')
			      ->class('form-control data-source')
			      ->controlsource('name')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
			'phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('phone')->caption('Mobile phone')
			      ->ng_model('form.phone')
			      ->class('form-control data-source')
			      ->controlsource('phone')->controltype('textbox')
			      ->value($model != NULL ? $model->phone : '')
			      ->out(),
			'flight_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('flight_nr')->caption('Flight Nr')
			      ->ng_model('form.flight_nr')
			      ->class('form-control data-source')
			      ->controlsource('flight_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->flight_nr : '')
			      ->out(),
			'coming_from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('coming_from')->caption('Coming from')
			      ->ng_model('form.coming_from')
			      ->class('form-control data-source')
			      ->controlsource('coming_from')->controltype('textbox')
			      ->value($model != NULL ? $model->coming_from : '')
			      ->out(),
			'resident_phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('resident_phone')->caption('Resident phone')
			      ->ng_model('form.resident_phone')
			      ->class('form-control data-source')
			      ->controlsource('resident_phone')->controltype('textbox')
			      ->value($model != NULL ? $model->resident_phone : '')
			      ->out(),
			'from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from')->caption('Adress')
			      // ->ng_model('form.from')
			      ->class('form-control data-source booking')
			      ->readonly('0')
			      ->controlsource('from')->controltype('textbox')
			      ->value($quick != NULL ? $quick['from'] : '')
			      ->out(),
			'from_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from_nr')->caption('Pick up')
			      // ->ng_model('form.from_nr')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source booking')
			      ->controlsource('from_nr')->controltype('textbox')
			      ->value($quick != NULL ? $quick['from_nr'] : '')
			      ->out(),
			'to' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to')->caption('To') 
			      // ->ng_model('form.to')
			      ->readonly('0')
			      ->class('form-control data-source')
			      ->controlsource('to')->controltype('textbox')
			      ->value($quick != NULL ? $quick['to'] : '')
			      ->out(),
			'to_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_nr')->caption('To')
			      // ->ng_model('form.to_nr')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source booking')
			      ->controlsource('to_nr')->controltype('textbox')
			      ->value($quick != NULL ? $quick['to_nr'] : '')
			      ->out(),
			'to_street' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_street')->caption('To street	')
			      ->ng_model('form.to_street')
			      ->class('form-control data-source')
			      ->controlsource('to_street')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),  
			'up_date' =>	     
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
				->name('up_date')
				->caption('Pick up date')
				->class('form-control calendar date-picker data-source')->readonly(0)
				->controlsource( 'up_date')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
				->out(),
	     	'nr_passegers' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('nr_passegers')
	            ->ng_model('form.nr_passegers')
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
	            ->ng_model('form.nr_luggages')
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
	            ->ng_model('form.nr_hand_luggages')
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
				->ng_model('form.details')
				->caption('Special Requirement')
				->controlsource('Special Requirement')
				->controltype('editbox')
				->class('form-control input-sm data-source')
				->out(),
			'meet_and_greet' =>
					\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
					->caption('Meet and greet +5£')
					->name('meet_and_greet')->placeholder('Textbox') 
					->value('Meet and greet +5£.')->class('form-control input_label')->enabled(0)
					->addon([
					'before' => 
						\Form::checkbox('meet_and_greet', '1', false,
							['class' => 'data-source icheck', 'id' => 'meet_and_greet',
							'data-checkbox' => 'icheckbox_square-green', 'data-control-source' => 'meet_and_greet',
							'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0, 'ng-model' => 'form.meet_and_greet']
					),
					'after' => NULL])
					->out(),
			'return_50' =>
					\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
					->caption('Return +50%')
					->name('return_50')->placeholder('Return +50%')
					->value('Return +50%.')->class('form-control input_label')->enabled(0)
					->addon([
					'before' => 
						\Form::checkbox('return_50', '1', false,
							['class' => 'data-source icheck', 'id' => 'return_50',
							'data-checkbox' => 'icheckbox_square-green', 'data-control-source' => 'return_50',
							'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0]
					),
					'after' => NULL])
					->out(),
			'pay_cash' =>
					\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
					->caption('Pay cash')
					->name('pay_cash')->placeholder('Pay cash')
					->value('Pay cash.')->class('form-control input_label')->enabled(0)
					->addon([
					'before' => 
						\Form::checkbox('pay_cash', '1', false,
							['class' => 'data-source icheck', 'id' => 'pay_cash',
							'data-checkbox' => 'icheckbox_square-green', 'data-control-source' => 'pay_cash',
							'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0]
					),
					'after' => NULL])
					->out()

			];
	}
 
}
