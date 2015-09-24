<?php namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\User;
use App\Models\Student;
use App\Models\Custodian;
use App\Models\Chat;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\InvitationSender;
use Illuminate\Http\Request;

class ChatController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 
	protected $availableUsers;

   /** @var Request */
	protected $request;

	public function __construct(Request $request, InvitationSender $inviter) {
		$this->request = $request;
		$this->inviter = $inviter;
	}

	public function index()
	{ 
	            
        // ====== //

		$institution = Institution::current();
		$user        = Auth::user(); 
		$role 		 = $user->getOriginal('userable_type');

		$availableUsers = Institution::current()->users()->get(); 
		$availableUsers->load('userable');
		// imi trebuie o metoda sa tai userul autentificat, din lipsa de timp fac acest foreach, voi reveni
		foreach($availableUsers as $elementKey => $element) {
			$element->send_messages = Chat::where('send_to', $user->id)->where('send_by',$element->id)->where('read','0')->count();
			if($element->id == $user->id){
				unset($availableUsers[$elementKey]);
			}
		}  
		
		return [
			'users' => $availableUsers,
			'auth'  => $user
			];                            

		if($role)
		switch ($role) {
			// super admin
			case 'superadmin':
				return $availableUsers = User::withoutself()->get()->toArray();
				break;
			// secretara
			case 'admin':
				break;
			// parinte
			case 'custodian':
					
				break;
			// student
			case 'student':
					
				break;
			// profesor
			case 'teacher':


					
				break;
			
			default:
				return [];
				break;
		}

		if ($user->getOriginal('userable_type') == 'custodian') {
            $student_uid = Session::get('student.user.id');
            $student     = User::find($student_uid)->userable;
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function indexChat(){
		$send_to = \Input::get('id_dest');
		$send_by = Auth::user()->id;
		$refresh = \Input::get('refresh');

		$messages = Chat::whereRaw('send_by = '.$send_by.' AND send_to = '.$send_to.' OR ( send_by = '.$send_to.' AND send_to = '.$send_by .')')
		->with('from')
		->get();

		if($refresh == 0)
			foreach ($messages as $key => $message) {
				Chat::where('send_to', $send_by)->update(['read'=>1]);
			}
		foreach ($messages as $key => $message) {
			$message->from['image'] = $message->from->userable->image;
		}
		return $messages;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// id_dest
		$send_to = \Input::get('id_dest');
		$send_by = \Input::get('id_from');
		$message = \Input::get('message');
		$new 	 = new Chat();
		$new->send_to = $send_to;
		$new->send_by = $send_by;
		$new->message = $message;
		$new->send_at_time = date('Y-m-d H:i:s');
		$new->save();
		$messages = Chat::whereRaw('send_by = '.$send_by.' AND send_to = '.$send_to.' OR ( send_by = '.$send_to.' AND send_to = '.$send_by .')')->with('from')->get()->toArray();
		return $messages;

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function checkMessages()
	{
		$send_to = Auth::user()->id;


		$new_messages = Chat::where('send_to',$send_to)->where('read','0')->with('from')->get()->toArray();
		return $new_messages; 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
