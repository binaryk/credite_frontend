<?php namespace App\Libs;

use App\Http\Requests\Request;

class GroupsRequest extends Request {

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
 			   'master_id' => 'exists:users,id,userable_type,teacher',
	           'num'       => 'required',
	           'letter'    => 'required',
		];
	}

	public function messages() {
		return [
			'num.required'    => 'Nu aÈ›i selectat clasa',
            'letter.required' => 'Nu aÈ›i selectat litera',
		];
	}

}
