<?php

namespace Imobiliare\Imobile\Form;

class Admins extends \Processing\Form\Form
{

    /**
     * @return Admins, obiect cu toate textbox-urile, cu blade-ul formularului, modelul, buttons (adauga, salveaza, sterge)
     */
    public static function make()
	{
//      apelez constructorul din Form
/*      $this->controls = new Collection();
        $this->addControls();
        $this->setView();
        $this->setModel();
        $this->setProperties(); */
		return self::$instance = new Admins();
	}

	protected function setView()
	{
		$this->view('dezvoltatori.form');	
	}

	protected function setModel()
	{
		$this->model('Imobiliare|Dezvoltator');
	}

	protected function addControls()
	{
		// denumire_tip
		$this->addControl(
			\Easy\Form\Textbox::make('~libs.~layouts.form.controls.textboxes.textbox')
		      ->name('title')->caption('Title')->placeholder('Title')
		      ->class('form-control input-sm data-source')
		      ->controlsource('title')->controltype('textbox')
		      ->out()
		);  

	}
}