<?php

/*administratori pagina table*/

Route::get('administrators', [
	'as'   => 'admins-index',
	'uses' => '\Libs\AdminsController@index',
]); 

Route::get('administrators-row-source', [
	'as'   => 'index-admins-row-sources',
	'uses' => '\Libs\AdminsController@rows' 
]);

Route::get('administrators/add', [
	'as'   => 'admins-add',
	'uses' => '\Libs\AdminsController@getAdd' 
]);

Route::post('administrators/add', [
	'as'   => 'admins-add-post',
	'uses' => '\Libs\AdminsController@postAdd' 
]);

Route::get('administrators/edit/{id}', [
	'as'   => 'admins-edit',
	'uses' => '\Libs\AdminsController@getEdit' 
]);

Route::post('administrators/edit-post/{id}', [
	'as'   => 'admins-edit-post',
	'uses' => '\Libs\AdminsController@postEdit' 
]);

Route::post('administrators/remove/{id}', [
	'as'   => 'admins-remove',
	'uses' => '\Libs\AdminsController@postRemove' 
]);