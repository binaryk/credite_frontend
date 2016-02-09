<?php namespace App\Http\Controllers\Client\Traits;

use App\Models\Nevoie;

trait FisaFormControls{

    public function build()
    {
        $form = PersoaneFiziceForm::make();
        $this->fields = $form->getControls();
        return $this->fields;
    }

}