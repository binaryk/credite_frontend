<?php namespace App\Libs;

use App\Http\Requests\Request;
use App\Models\Student;

class StudentsRequest extends Request {

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
            'email'                     => 'required|email|unique:users,email',
            'password'                  => ['required', 'regex:/(?=.*[A-Z].*)(?=.*[^a-zA-Z0-9].*)/', 'confirmed', 'min:7'],
            'firstname'                 => 'required',
            'lastname'                  => 'required',
            'dob'                       => 'required',
            'cnp'                       => 'required|digits:13',
            "parents_initials"          => "required",
            // "gender"                    => "in:" . implode(',', Student::getGenders()),
            "emergency_phone"           => "required",
            "secondary_emergency_phone" => "required",
		];
	}

	public function messages() {
		return [
            'email.required'                     => 'Introduceți o adresă de email',
            'email.email'                        => 'Introduceți o adresă de email validă',
            'email.unique'                       => 'Cineva folosește deja această adresa de email',
            'password.required'                  => 'Câmpul parolă este obligatoriu',
            'password.confirmed'                 => 'Parolele introduse nu coincid',
            'password.min'                       => 'Parola trebuie să aibă minim 7 caractere',
            'password.regex'                     => 'Parola trebuie să conțină cel putin o majusculă și un caracter special',
            'firstname.required'                 => 'Câmpul nume este obligatoriu',
            'lastname.required'                  => 'Câmpul prenume este obligatoriu',
            'dob.required'                       => 'Nu ați introdus data nașterii',
            'cnp.required'                       => 'Câmpul CNP este obligatoriu',
            'parents_initials.required'          => 'Câmpul inițiala tatălui este obligatoriu',
            'emergency_phone.required'           => 'Nu ați introdus un număr de telefon de urgență',
            'secondary_emergency_phone.required' => 'Nu ați introdus un număr de telefon secundar de urgență',
		];
	}

}
