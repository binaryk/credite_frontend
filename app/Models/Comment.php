<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;
    protected $table = 'comments';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public static function valid()
    {
        return self::where('valid','1')->get();
    }
}