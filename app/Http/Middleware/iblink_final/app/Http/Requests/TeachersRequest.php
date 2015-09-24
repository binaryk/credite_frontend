<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TeachersRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'firstname' => 'required',
			'cnp' => 'required|digits:13',
		];
	}

	public function messages() {
		return [
			'firstname.required' => 'Câmpul nume este obligatoriu',
			'cnp.required' => 'Câmpul CNP este obligatoriu',
			'cnp.digits' => 'Câmpul CNP nu conține 13 cifre',
		];
	}

}
