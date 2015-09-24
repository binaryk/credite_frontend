<?php namespace App\Libs;

use App\Http\Requests\Request;

class TeacherRequest extends Request {

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
			'email' => 'required|email|unique:users,email',
			'password' => ['regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
			'firstname' => 'required',
			'lastname' => 'required',
			'cnp' => 'required|digits:13',
		];
	}

	public function messages() {
		return [
			'email.required' => 'Introduceți o adresă de email',
			'email.email' => 'Introduceți o adresă de email validă',
			'email.unique' => 'Cineva folosește deja această adresa de email',
			'password.confirmed' => 'Parolele introduse nu coincid',
			'password.min' => 'Parola trebuie să aibă minim 7 caractere',
			'password.regex' => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
			'firstname.required' => 'Câmpul prenume este obligatoriu',
			'lastname.required' => 'Câmpul nume este obligatoriu',
			'cnp.required' => 'Câmpul CNP este obligatoriu',
			'cnp.digits' => 'Câmpul CNP nu conține 13 cifre',
		];
	}

}
