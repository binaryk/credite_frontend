<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nevoie extends Model implements IModel
{

    use SoftDeletes;
    protected $table = 'front_nevoi';
    protected $guarded = [];


    public function rules()
    {
        return [
            'email' => 'required|email',
            'phone' => 'required',
            'details' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Campul de mail este obligatoriu',
            'email.email' => 'Campul de nu este valid',
            'phone.required' => 'Telefonul este obligatoriu, pentru a va putea identifica in caz de urgenta.',
            'details.required' => 'Avem nevoie de detalii pentru a va depista un produs cat mai bun.',
        ];
    }

}