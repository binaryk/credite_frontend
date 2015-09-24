<?php

/*profesori pagina table*/

Route::get('teachers-index', [
	'as'   => 'teachers-index',
	'uses' => '\Libs\TeachersController@index',
]); 

Route::get('teachers-row-source', [
	'as'   => 'index-teachers-row-sources',
	'uses' => '\Libs\TeachersController@rows' 
]);

Route::get('teachers-add', [
	'as'   => 'teachers-add',
	'uses' => '\Libs\TeachersController@getAdd' 
]);

Route::post('teachers-add', [
	'as'   => 'teachers-add-post',
	'uses' => '\Libs\TeachersController@postAdd' 
]);

Route::get('teachers-edit/{id}', [
	'as'   => 'teachers-edit',
	'uses' => '\Libs\TeachersController@getEdit' 
]);

Route::post('teachers-edit-post/{id}', [
	'as'   => 'teachers-edit-post',
	'uses' => '\Libs\TeachersController@postEdit' 
]);

Route::post('teachers-remove/{id}', [
	'as'   => 'teachers-remove',
	'uses' => '\Libs\TeachersController@postRemove' 
]);