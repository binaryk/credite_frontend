<?php namespace App\Http\Controllers\Client\Traits;

trait ProfileFormControls{

    public function build($model)
    {
        $this->fields = [
            'fname' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('fname')->caption('Prenume')
                    ->class('form-control data-source')
                    ->controlsource('fname')->controltype('textbox')
                    ->value($model != NULL ? $model->fname : '')
                    ->out(),
            'lname' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('lname')->caption('Nume')
                    ->class('form-control data-source')
                    ->controlsource('lname')->controltype('textbox')
                    ->value($model != NULL ? $model->lname : '')
                    ->out(),
            'email' =>
                \Easy\Form\Textbox::make('~layouts.form.controls.textboxes.textbox')
                    ->name('email')->caption('Email')
                    ->help('Nu puteti edita emailul')
                    ->class('form-control data-source')
                    ->readonly(1)
                    ->controlsource('email')->controltype('textbox')
                    ->value($model != NULL ? $model->email : '')
                    ->out(),
        ];
        return $this->fields;
    }

}