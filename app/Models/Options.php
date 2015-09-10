<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Options
{
	protected static $options = [
		'1' => 'Address',
		'2' => 'Airport',
		'3' => 'Postal code',
		// '4' => 'Choose your pickup adress',
	];

	public static function toCombobox(){
	 	return self::$options;
	 }  
}