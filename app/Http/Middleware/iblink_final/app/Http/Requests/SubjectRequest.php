<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Institution;
class SubjectRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name'           => 'required',
			'type'           => 'required',
			'teacher_id'        => 'required',
			'grading_system' => 'required',
			'institution_id' => 'required|exists:institutions,id,id,' . Institution::current()->id,
		];
	}

	public function messages()
	{
		return [
			'name.required'           => 'Câmpul nume este obligatoriu',
			'type.required'           => 'Nu ați selectat tipul disciplinei',
			'teacher_id.required'        => 'Nu ați selectat titularul',
			'grading_system.required' => 'Nu ați selectat sistemul de evaluare',
		];
	}

}
