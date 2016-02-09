<?php namespace App\Http\Controllers\Client\Traits;

use App\Models\Nevoie;

trait SolicitariFormControls{

    public function table()
    {
        return Nevoie::where('user_id', Auth()->user()->id)->get();
    }

}