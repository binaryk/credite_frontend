<?php

/*profesori pagina table*/

Route::get('students-index', [
	'as'   => 'students-index',
	'uses' => '\Libs\StudentsController@index',
]); 

Route::get('students-row-source', [
	'as'   => 'index-students-row-sources',
	'uses' => '\Libs\StudentsController@rows' 
]);

Route::get('students-add', [
	'as'   => 'students-add',
	'uses' => '\Libs\StudentsController@getAdd' 
]);

Route::post('students-add', [
	'as'   => 'students-add-post',
	'uses' => '\Libs\StudentsController@postAdd' 
]);

Route::get('students-edit/{id}', [
	'as'   => 'students-edit',
	'uses' => '\Libs\StudentsController@getEdit' 
]);

Route::post('students-edit-post/{id}', [
	'as'   => 'students-edit-post',
	'uses' => '\Libs\StudentsController@postEdit' 
]);

Route::post('students-remove/{id}', [
	'as'   => 'students-remove',
	'uses' => '\Libs\StudentsController@postRemove' 
]);