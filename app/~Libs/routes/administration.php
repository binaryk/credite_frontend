<?php

Route::get('administration', [
	'as'   => 'administration',
	'uses' => '\App\Http\Controllers\AdminController@index',
]);

Route::get('users-view', [
	'as' => 'users-view',
	'uses' => '\App\Http\Controllers\AdminController@users'
]);