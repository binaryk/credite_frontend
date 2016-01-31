<?php namespace App\Http\Controllers\Booking;

use App\Jobs\SendOrderEmail;
use App\Jobs\SendToClientOrder;
use App\Models\Destination;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;

class BookingController extends PreBookingController {

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

	public function destination($type = NULL, $destination = NULL, $switched = NULL){
		$data['caption'] = 'BOOKING DETAILS FORM';
		$quick = [];
		$destination  = Destination::find($destination);
        $to    = $destination['to'];
        $from  = $destination['from'];
        if($switched != NULL && $switched == '1'){
            $quick['to'] = $from;
            $quick['from'] = $to;
        }else{
            if($switched != NULL && $switched == '0'){
                $quick['to'] = $to;
                $quick['from'] = $from;
            }
        }
		$data['steps'] = $this->steps($quick);
		return view('booking.form.index')->with(compact('data', 'destination'));
	}

    public function fromRequest($id_req, $id_res)
    {
        $data['caption'] = 'BOOKING DETAILS FORM';
        $request = Order::find($id_req);
        $response = \App\Models\Response::find($id_res);
        $quick = [
            'from' => $request->from,
            'to' => $request->to,
        ];
        $data['steps'] = $this->steps($quick, $request);
        $destination = [
            'price' => $response->price,
        ];
        $price = $response->price;
        return view('booking.form.index')->with(compact('data', 'destination', 'price'));
    }
    /*
     * after payment submit
     * action*/
    public function onlinePay($id_req = null)
    {

        /*
         * in:
         *    "from" => "Stansted"
              "to" => "Norwich"
              "from_nr" => ""
              "to_nr" => ""
              "email" => "lupacescueduard@yahoo.com"
              "name" => ""
              "phone" => "1561654"
              "up_date" => ""
              "hour" => ""
              "details" => ""
              "token" => "mWn48p7Hz9qXON2kfbT1L5TG7b1Uhcjfh2fmCTMd"
              "_token" => "mWn48p7Hz9qXON2kfbT1L5TG7b1Uhcjfh2fmCTMd"
              "stripeToken" => "tok_17WtBpDukBCaTxLedQN7orWH"
              "stripeTokenType" => "card"
              "stripeEmail" => "lupacescueduard@yahoo.com"
         * */
        if($id_req){
            /*from request*/
            Order::where('id',$id_req)->update([
                'request' => '0',
            ]);
        }

        $up_date_time = Input::get('up_date_time');
        if(count($up_date_time) > 0){
            $datetime = new Carbon($up_date_time);
        }else{
            $datetime = Carbon::now();
        }
        $data = Input::all() + [ 'up_date_time' => $datetime->toDateTimeString(), 'time_string' => $datetime->formatLocalized('%A %d %B %Y'), 'diff' => $datetime->diffForHumans(), ];
        $job        = new SendOrderEmail($data);//)->onQueue('emails');
        $job_extern = new SendToClientOrder($data);//)->onQueue('emails');
        $this->dispatch($job);
        $this->dispatch($job_extern);
        return redirect()->route('home')->withFlashSuccess(trans('strings.form_submit_success'));

        /*<?php
          require_once('./config.php');
          $token  = $_POST['stripeToken'];
          $customer = \Stripe\Customer::create(array(
              'email' => 'customer@example.com',
              'card'  => $token
          ));
          $charge = \Stripe\Charge::create(array(
              'customer' => $customer->id,
              'amount'   => 5000,
              'currency' => 'usd'
          ));
          echo '<h1>Successfully charged $5!</h1>';
        ?>*/
    }

	public function steps($quick = NULL, $model = NULL){
	return $steps = [
		'records' => $this->controls( (object) $quick, $model),
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
			],
			[
				'caption' => 'Confirm',
				'help'    => '',
				'view'    => '3'
			]
		]

	];
	}


	public function controls($quick = NULL, $model = NULL){

		return [
			'email' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('email')->caption('Email')
			      // ->placeholder('Email')
			      ->class('form-control data-source')
			      ->controlsource('email')->controltype('textbox')
			      ->value($model != NULL ? $model->email : '')
                    ->readonly($model != NULL ? '1' : '0')
			      ->out(),
			'name' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('name')->caption('Name')
			      ->class('form-control data-source')
			      ->controlsource('name')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
                    ->readonly($model != NULL ? '1' : '0')
			      ->out(),
			'phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('phone')->caption('Mobile phone')
			      ->class('form-control data-source')
			      ->controlsource('phone')->controltype('textbox')
			      ->value($model != NULL ? $model->phone : '')
                  ->readonly($model != NULL ? '1' : '0')
			      ->out(),
			'flight_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('flight_nr')->caption('Flight Nr')
			      ->class('form-control data-source')
			      ->controlsource('flight_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->flight_nr : '')
			      ->out(),
			'coming_from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('coming_from')->caption('Coming from')
			      ->class('form-control data-source')
			      ->controlsource('coming_from')->controltype('textbox')
			      ->value($model != NULL ? $model->coming_from : '')
			      ->out(),
			'resident_phone' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('resident_phone')->caption('Resident phone')
			      ->class('form-control data-source')
			      ->controlsource('resident_phone')->controltype('textbox')
			      ->value($model != NULL ? $model->resident_phone : '')
			      ->out(),
			'from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from')->caption('Adress')
			      ->class('form-control data-source')
			      ->readonly('1')
			      ->controlsource('from')->controltype('textbox')
			      ->value($quick != NULL ? $quick->from : '')
			      ->out(),
			'from_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from_nr')->caption('Pick up')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source')
			      ->controlsource('from_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->from_nr : '')
                  ->readonly($model != NULL ? '1' : '0')
			      ->out(),
			'to' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to')->caption('To')
			      ->readonly('1')
			      ->class('form-control data-source')
			      ->controlsource('to')->controltype('textbox')
			      ->value($quick != NULL ? $quick->to : '')
			      ->out(),
			'to_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_nr')->caption('To')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source')
			      ->controlsource('to_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->to_nr : '')
			      ->out(),
			'to_street' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_street')->caption('To street	')
			      ->class('form-control data-source')
			      ->controlsource('to_street')->controltype('textbox')
			      ->value($model != NULL ? $model->to_street : '')
			      ->out(),  
			'up_date_time' =>
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
				->name('up_date_time')
				->caption('Pick up date')
				->class('form-control calendar date-picker data-source')
                ->readonly($model != NULL ? '1' : '0')
                ->value($model != NULL ? $model->up_date_time : '')
				->controlsource( 'up_date_time')->controltype('textbox')
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
                ->value($model != NULL ? $model->details : '')
                    ->readonly($model != NULL ? '1' : '0')
				->class('form-control input-sm data-source')
				->out(),
			'meet_and_greet' =>
					\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
					->caption('Meet and greet +5£')
					->name('meet_and_greet')->placeholder('Textbox') 
					->value('Meet and greet +5£.')->class('form-control input_label')
                        ->enabled(0)
					->addon([
					'before' => 
						\Form::checkbox('meet_and_greet', '1', $model != NULL ? $model->meet_and_greet : false,
							['class' => 'data-source icheck', 'id' => 'meet_and_greet',
							'data-checkbox' => 'icheckbox_square-green', 'data-control-source' => 'meet_and_greet',
							'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0] + ($model != NULL ? ['disabled' => 'disabled'] : [])
					),
					'after' => NULL])
					->out(),
			'return_50' =>
					\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
					->caption('Return +50%')
					->name('return_50')->placeholder('Return +50%')
					->value('Return +50%.')->class('form-control input_label')
                        ->enabled(0)
					->addon([
					'before' => 
						\Form::checkbox('return_50', '1', $model != NULL ? $model->return_50 : false,
							['class' => 'data-source icheck', 'id' => 'return_50',
							'data-checkbox' => 'icheckbox_square-green', 'data-control-source' => 'return_50',
							'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0] + ($model != NULL ? ['disabled' => 'disabled'] : [])
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
