<?php namespace Libs;

class CommonsController extends \Commons\IBlinkController
{

	public function getSemestersByYear()
	{
		$semesters = \App\Models\Semester::where('year_id', \Input::get('year_id'))->orderBy('order_no')->get();

		foreach ($semesters as $i => $record) 
		{
			$record->url_to_change = \URL::route('change-semester', ['semester_id' => $record->id ]);
		}

		return \Response::json(['semesters' => $semesters]);
	}

	public function changeSemester($id)
	{
		$semester = \App\Models\Semester::find( (int) $id );
		if($semester)
		{
			$this->institution->active_semester_id = $id;
			$this->institution->save();
		}
		return \Redirect::to(\URL::previous());
	}
}