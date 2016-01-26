<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{

    use SoftDeletes;
    protected $table = 'destinations';
    protected $dates = ['deleted_at'];




}