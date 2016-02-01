<?php namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Comment;
use App\Models\Destination;
use App\Models\Options;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

	public function __construct()
	{
	}

	public function index()
	{
//		$controls = $this->controls();
//        $airports = Destination::where('type','airport')->get();
//        $ports    = Destination::where('type','port')->get();
        $comments = Comment::valid();
		return view('pages.home')->with(compact('comments'));
	} 

	public function controls($type = NULL, $model = NULL){
		return [
	     	 'from' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from')
			      ->caption('From')
				  ->placeholder('Give please accurate address including post code')
			      ->class('form-control data-source')
			      ->controlsource('from')->controltype('textbox')
			     ->out(),
	     	 'from_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('from_nr')->caption('Pick up')
			      ->ng_model('form.from_nr')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source')
			      ->controlsource('from_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(),
	     	 'to' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to')
			      ->caption('To')
				  ->placeholder('Give please accurate address including post code')
			      ->class('form-control data-source')
			      ->controlsource('to')->controltype('textbox')
			     ->out(),
			'to_nr' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('to_nr')->caption('To')
			      ->ng_model('form.to_nr')
			      ->placeholder('postcode: (NR1 to NR7 only), house number,street')
			      ->class('form-control data-source')
			      ->controlsource('to_nr')->controltype('textbox')
			      ->value($model != NULL ? $model->name : '')
			      ->out(), 
	     	 'locality' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('locality')
			      ->caption('City')
			      ->class('form-control data-source')
			      ->controlsource('locality')->controltype('textbox')
			     ->out(), 
	     	 'country' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name('country')
			      ->caption('Country')
			      ->class('form-control data-source')
			      ->controlsource('country')->controltype('textbox')
			     ->out(),  
			 'postal_code' =>	     
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
				->name('postal_code')
				->caption('Postal code')
				->class('form-control data-source')->readonly(0)
				->controlsource('postal_code')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-envelope"></i>', 'after' => NULL])
				->out(),
	     	 'options' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('option')
	            ->caption('Pick-up Point:')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource('option')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(['' => '- Select -'] + Options::toCombobox())
	            ->out(),
	     	 'airport' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name('airport')
	            ->caption('Airport:')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource('airport')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(Airport::toCombobox())
	            ->out(), 
		];
	}



}