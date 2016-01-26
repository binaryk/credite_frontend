<?php namespace Mailers;

class GeneralMailer extends Mailer
{
	public function subscribe($e)
	{		
		$e->listen('client.send-confirm-email', 'Mailers\ClientMailer@confirmareFormular'); 
	}

	public function submitPay($client, $admin = NULL)
	{
		return $this->sendTo(
			'lupacescueduard@yahoo.com',
			'Clientul - ' . $client->nume . ' ' . $client->prenume,
			'emails.client.confirmare',
			[
				'body' => \View::make('extern.email-content')->with([
						'client'          => $client,
					])->render(),
				'client'  => $client,
			]
		);
	}
}