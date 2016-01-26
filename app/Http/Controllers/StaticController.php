<?php namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Destination;
use App\Models\Options;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class StaticController extends Controller {

    public function __construct()
    {
    }


    public function terms()
    {
        return view('pages.terms');
    }

}