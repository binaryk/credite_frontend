<?php namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Jobs\IdentificareNevoieMailAdmin;
use App\Models\Nevoie;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Client\Traits\FisaFormControls;
/**
 * Created by PhpStorm.
 * User: lupac
 * Date: 2/9/2016
 * Time: 12:34 PM
 */
class ClientFisaController extends Controller
{
    use FisaFormControls;
    protected $fields = [];

    public function index()
    {
        return view('client.fisa.index')->with([
            'controls' => $this->build()
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->all();
        User::where('id', Auth()->user()->id)->update([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
        ]);
        return Response::json(['message' => 'Salvarea a avut loc cu succes','code' => 200]);
    }
}