<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{

    use SoftDeletes;
    protected $table = 'responses';
    protected $guarded = [];
    protected $dates = ['deleted_at'];


}