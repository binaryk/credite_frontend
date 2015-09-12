<?php namespace App\Http\Controllers;

use App\Models\Airport; 
use App\Models\Options; 
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

	public function __construct()
	{
	}

	public function index()
	{
		dd('Noroc suka 2');

		// 

		$controls = $this->controls('up_');
		$controls1 = $this->controls('off_');
		$controls = array_merge($controls, $controls1);
		return view('pages.home')->with(compact('controls'));
	}

	public function getAirports(){
		$airports = Airport::all();
		return \Response::json(['airports' => $airports]);
	}

	public function controls($type = NULL, $model = NULL){
		$rez = ($type ? $type : '') ;

		return [
	     	$rez . 'address' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name($rez .'address')
			      ->caption('Adress')
			      ->class('form-control data-source')
			      ->controlsource( $rez . 'address')->controltype('textbox')
			     ->out(),
	     	$rez . 'street' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name($rez .'route')
			      ->caption('Street address')
			      ->class('form-control data-source')
			      ->controlsource( $rez . 'route')->controltype('textbox')
			     ->out(), 
	     	$rez . 'locality' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name($rez .'locality')
			      ->caption('City')
			      ->class('form-control data-source')
			      ->controlsource( $rez . 'locality')->controltype('textbox')
			     ->out(), 
	     	$rez . 'country' =>	
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
			      ->name($rez .'country')
			      ->caption('Country')
			      ->class('form-control data-source')
			      ->controlsource( $rez . 'country')->controltype('textbox')
			     ->out(),  
			$rez . 'postal_code' =>	     
				\Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox-addon')
				->name($rez .'postal_code')
				->caption('Postal code')
				->class('form-control data-source')->readonly(0)
				->controlsource( $rez . 'postal_code')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-envelope"></i>', 'after' => NULL])
				->out(),
	     	$rez . 'options' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name($rez .'option')
	            ->caption('Pick-up Point:')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource( $rez . 'option')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(['' => '- Select -'] + Options::toCombobox())
	            ->out(),
	     	$rez . 'airport' =>	
				\Easy\Form\Combobox::make('~layouts.form.controls.comboboxes.combobox')
	            ->name($rez .'airport')
	            ->caption('Airport:')
	            ->class('form-control data-source input-group form-select selectpicker init-on-update-delete')
	            ->controlsource( $rez . 'airport')
	            ->controltype('combobox') 
	            ->enabled('false')
	            ->options(Airport::toCombobox())
	            ->out(), 
		];
	}



}