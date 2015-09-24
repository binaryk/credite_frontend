<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupstudent extends Model {

    protected $table = 'group_student';
    protected $fillable = ['plus', 'minus' ];

    public function setUpdatedAt($value)
    {
       //Do-nothing
    }

    public function getUpdatedAtColumn()
    {
        //Do-nothing
    }

}
