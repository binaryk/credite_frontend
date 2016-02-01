<?php namespace App\Http\Controllers\Credite;

use App\Http\Controllers\Controller;
use App\Jobs\IdentificareNevoieMailAdmin;
use App\Models\Nevoie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Validator;

class IdentificareaNevoiiController extends Controller
{
    public function index()
    {
        return view('identificarea_nevoii.index')
            ->with([
             'steps' => $this->steps(),
             'caption' => 'Completati formularul pentru a va identifica tipul de credit specific',
            ]
        );
    }

    public function store(Request $request)
    {
        $rules = (new Nevoie)->rules();
        $messages = (new Nevoie)->messages();
        $this->validate($request, $rules, $messages);
        $inserted = Nevoie::create($request->all() );
        $job        = new IdentificareNevoieMailAdmin($inserted);
        $this->dispatch($job);
        return redirect()->back();
    }



    public function steps($quick = NULL, $model = NULL){
        return $steps = [
            'records' => $this->controls( (object) $quick, $model),
            'tabs' => [
                [
                    'caption' => 'Date generale',
                    'help'    => 'Introduceti datele dvs',
                    'view'    => '1',
                ],
                [
                    'caption' => 'Nevoia dvs',
                    'help'    => 'De ce aveti nevoie acum ?',
                    'view'    => '2'
                ],
                [
                    'caption' => 'Confirmare',
                    'help'    => 'Sunteti sigur ca ati completat tot formularul ?',
                    'view'    => '3'
                ]
            ]

        ];
    }

    public function controls($quick = NULL, $model = NULL){

        return [
            'email' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('email')->caption('Email')
                    // ->placeholder('Email')
                    ->class('form-control data-source')
                    ->controlsource('email')->controltype('textbox')
                    ->value($model != NULL ? $model->email : '')
                    ->readonly($model != NULL ? '1' : '0')
                    ->out(),
            'name' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('name')->caption('Nume')
                    ->class('form-control data-source')
                    ->controlsource('name')->controltype('textbox')
                    ->value($model != NULL ? $model->name : '')
                    ->readonly($model != NULL ? '1' : '0')
                    ->out(),
            'phone' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('phone')->caption('Telefon')
                    ->class('form-control data-source')
                    ->controlsource('phone')->controltype('textbox')
                    ->value($model != NULL ? $model->phone : '')
                    ->readonly($model != NULL ? '1' : '0')
                    ->out(),
            'details' =>
                \Easy\Form\Editbox::make('~layouts.form.controls.editboxes.editbox')
                    ->name('details')
                    ->caption('Detalii')
                    ->controlsource('details')
                    ->controltype('editbox')
                    ->value($model != NULL ? $model->details : '')
                    ->readonly($model != NULL ? '1' : '0')
                    ->class('form-control input-sm data-source')
                    ->out(),

        ];
    }
}