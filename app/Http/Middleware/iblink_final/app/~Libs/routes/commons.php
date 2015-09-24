<?php


Route::post('commons/get-year-semestres', [
	'as'   => 'get-year-semestres',
	'uses' => '\Libs\CommonsController@getSemestersByYear',
]);

Route::get('commons/change-semester/{semester_id}', [
	'as'   => 'change-semester',
	'uses' => '\Libs\CommonsController@changeSemester',
]);

