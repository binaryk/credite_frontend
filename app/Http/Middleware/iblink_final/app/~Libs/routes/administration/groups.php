<?php

/*profesori pagina table*/

Route::get('groups-index', [
	'as'   => 'groups-index',
	'uses' => '\Libs\GroupsController@index',
]); 

Route::get('groups-row-source', [
	'as'   => 'index-groups-row-sources',
	'uses' => '\Libs\GroupsController@rows' 
]);

Route::get('groups-add', [
	'as'   => 'groups-add',
	'uses' => '\Libs\GroupsController@getAdd' 
]);

Route::post('groups-add', [
	'as'   => 'groups-add-post',
	'uses' => '\Libs\GroupsController@postAdd' 
]);

Route::get('groups-edit/{id}', [
	'as'   => 'groups-edit',
	'uses' => '\Libs\GroupsController@getEdit' 
]);

Route::post('groups-edit-post/{id}', [
	'as'   => 'groups-edit-post',
	'uses' => '\Libs\GroupsController@postEdit' 
]);

Route::post('groups-remove/{id}', [
	'as'   => 'groups-remove',
	'uses' => '\Libs\GroupsController@postRemove' 
]); 

Route::get('groups-students-index/{id}', [
	'as'   => 'groups-students-index',
	'uses' => '\Libs\GroupsController@getStudents' 
]); 
Route::post('groups-students-add/{id}', [
	'as'   => 'groups-students-add',
	'uses' => '\Libs\GroupsController@postStudents' 
]); 

Route::get('groups-subjects-index/{id}', [
	'as'   => 'groups-subjects-index',
	'uses' => '\Libs\GroupsController@getSubjects' 
]); 
Route::post('groups-subjects-add/{id}', [
	'as'   => 'groups-subjects-add',
	'uses' => '\Libs\GroupsController@postSubjects' 
]);


/**
 	Studentii clasei
 * 
 */


Route::post('groups-students-get', [
	'as'   => 'show-students-group-form',
	'uses' => '\Libs\GroupsController@getStudents' 
]);
