<?php
namespace App\Http\Controllers\BookingFull; 

use App\User;
use App\Models\Order;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;
class PreBookingController extends \App\Http\Controllers\Controller {

	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function createUser($data){
		$user = User::where('email', $data['email'])->first();
		if(! $user){
			 $user = User::create([
	            'name' 	   	=> $data['name'],
	            'email' 	=> $data['email'], 
	            'phone' 	=> $data['phone'], 
	            'password' 	=> bcrypt($data['phone']),
	        ]);
		}
		 return $user;
	} 

	public function saveBook($data){ 

		$order = Order::create( $data );
		
		return $order;
	} 

}	