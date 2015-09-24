<?php

$environment = env('APP_ENV', 'ovidiu');

return [

	'fetch' => PDO::FETCH_CLASS,
	'default' => 'mysql',
	'connections' => [

		'mysql' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST',     'localhost'),
			'database'  => env('DB_DATABASE', (
				$environment == 'ovidiu' 
				? 'iblink' : 
				'iblink80_dev') 
			),
			'username'  => env('DB_USERNAME', 'root'),
			'password'  => env('DB_PASSWORD', (
				$environment == 'ovidiu' 
				? 'babalean' : 
				'') 
			),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],

	],

	'migrations' => 'migrations',
	'redis' => [

		'cluster' => false,

		'default' => [
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		],

	],

];
