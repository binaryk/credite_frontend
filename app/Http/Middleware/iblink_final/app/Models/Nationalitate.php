<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nationalitate extends Model {

    protected $fillable = ['name', 'master_id', 'year_id', 'num', 'letter'];

    protected static $nationalitate = [
        1  => 'Romania',
        2  => 'America',
        3  => 'Moldova',
        4  => 'Bulgaria',
        5  => 'Turcia', 
    ];


    public static function toCombo(){
        return self::$nationalitate;
    }

}