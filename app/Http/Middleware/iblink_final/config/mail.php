<?php

return [

	'driver' => "mail",
	'host' =>env('MAIL_HOST', 'mail.iblink.ro'),
	'port' => env('MAIL_PORT', 26),
	'from' => ['address' =>'no-reply@iblink.ro', 'name' => 'iBlink.ro'],
	'encryption' => env('MAIL_ENCRYPTION', 'tls'),
	'username' => 'no-reply@iblink.ro',
	'password' => 'replay100@',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,

	/*'driver' =>  'smtp',
	'host' => 'mail.iblink.ro',
	'port' =>  26,
	'from' => ['address' => 'no-reply@iblink.ro', 'name' => 'iBlink.ro'],
	'encryption' =>  'tls',
	'username' => 'no-replay@iblink.ro',
	'password' => 'replay100@',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,*/
	
	
	/*

	'driver' => env('MAIL_DRIVER', 'smtp'),
	'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
	'port' => env('MAIL_PORT', 587),
	'from' => ['address' => 'no-reply@iblink.ro', 'name' => 'iBlink.ro'],
	'encryption' => env('MAIL_ENCRYPTION', 'tls'),
	'username' => env('MAIL_USERNAME'),
	'password' => env('MAIL_PASSWORD'),
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,*/
	
	/*
	'driver'     => 'smtp',
	'host'       => 'smtp.gmail.com',
	'port'       => 465,
	'from'       => ['address' => 'lupacescueduard@gmail', 'name' => 'Eduard'],
	'encryption' => 'ssl',
	'username'   => "lupacescueduard@gmail.com",
	'password'   => "Wh95Q0VC2M",
	'sendmail'   => '/usr/sbin/sendmail -bs',
	'pretend'    => false*/

 
];
