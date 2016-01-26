<?php

namespace App\Http\Controllers;

use App\Jobs\RequestResponseEmail;
use App\Models\Comment;
use App\Models\Order;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class AdminRequestController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $requests = Order::requests();
        $orders = Order::noRquests();
        return view('administration.requests.index')->with(compact('requests','orders'));
    }

    public function response($id)
    {
        $request = Order::where('id',$id)->with('responses')->first();
        return view('administration.requests.response.index')->with(compact('request'));

    }

    public function postResponse($id)
    {
        /*Job de trimitere mail catre client*/
        $res  = \App\Models\Response::create([
                'order_id' => $id,
                'price' => Input::get('price'),
                'message' => Input::get('message'),
            ]);
        $request = Order::find($id);
        $request->response = '1';
        $request->save();
        $job = new RequestResponseEmail($res, $request);
        $this->dispatch($job);
        return view('comments.alert')->with(['message' => trans('strings.request_submit')])->render();
    }


}
