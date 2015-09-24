<?php namespace Commons;

class IBlinkController extends \App\Http\Controllers\Controller
{

	// protected $layout        = "layouts.master";

	protected $current_user        = NULL;
	protected $user_type           = NULL;
	protected $person              = NULL;
	protected $institution         = NULL;
	protected $semester            = NULL;
	protected $semestres           = NULL;
	protected $year                = NULL;
	protected $years               = NULL;

	public function __construct()
	{

		/**
		 * aici aflu userul curent (current_user)
		 **/
		if( is_null($this->current_user = \Auth::user()) )
		{
			return \Redirect::to('auth/login')->send();
		}
		$this->user_type = $this->current_user->userable_type;
		
		$this->person = call_user_func([$this->current_user->userable_type, 'find'], $this->current_user->userable_id);
		/**
		 * aici aflu institutia curenta (institution)
		 **/
		if( is_null($this->institution = \App\Models\Institution::current()) )
		{
			return \Redirect::to('auth/switcher')->send();
		}
		/**
		 * Se pune problema in ce semestru ne aflam (lucram)
		 **/
		$this->semester = \App\Models\Semester::find($this->institution->active_semester_id);
		$this->year = \App\Models\Year::find($this->semester->year_id);
		$this->semestres = \App\Models\Semester::where('year_id', $this->year->id)->orderBy('order_no')->get();
		foreach($this->semestres as $i => $record)
		{
			$record->current = ($record->id == $this->institution->active_semester_id);
		}

		\View::share('current_user', $this->current_user);
		\View::share('user_type', $this->user_type);
		\View::share('person', $this->person);
		\View::share('institution', $this->institution);
		\View::share('semester', $this->semester);
		\View::share('semestres', $this->semestres);
		\View::share('year', $this->year);
		\View::share('years', $this->years = \App\Models\Year::orderBy('name')->get() );

	}

}