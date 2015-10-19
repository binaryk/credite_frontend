<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
    protected $table = 'orders';
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function user(){
    	return $this->belongsTo('\App\User','user_id');
    } 
 
}