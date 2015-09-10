<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{

    use SoftDeletes;
    protected $table = 'airports';
    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];

	
	private $rules = array(
			'name' => 'required|min:2', 
	); 

	public static function toCombobox(){
		return self::orderBy('name')->lists('name','id');
	} 
}