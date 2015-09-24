<?php

/** 
 * Notele copilului meu
 **/

Route::get('parinte/notele-elevului/{id?}', [
	'as'   => 'index-parinte-note-elev',
	'uses' => '\Libs\ParinteMateriielevController@index',
]);

Route::get('profesor/notele-elevului-row-sources/{clasa_id}/{id?}', [
	'as'   => 'index-parinte-note-elev-row-sources',
	'uses' => '\Libs\ParinteMateriielevController@rows' 
]);

Route::post('profesor/get-student-grades', [
	'as'   => 'get-student-grades',
	'uses' => '\Libs\ParinteMateriielevController@getStudentGrades',
]);

Route::post('profesor/get-student-averages', [
	'as'   => 'get-student-averages',
	'uses' => '\Libs\ParinteMateriielevController@getStudentAverages',
]);

/**
 * Absentele copilului meu
 **/

Route::get('parinte/absentele-elevului/{id?}', [
	'as'   => 'index-parinte-absente-elev',
	'uses' => '\Libs\ParinteAbsenteelevController@index',
]);

Route::get('profesor/absentele-elevului-row-sources/{clasa_id}/{id?}', [
	'as'   => 'index-parinte-absente-elev-row-sources',
	'uses' => '\Libs\ParinteAbsenteelevController@rows' 
]);

Route::post('profesor/get-student-absente', [
	'as'   => 'get-student-absente',
	'uses' => '\Libs\ParinteAbsenteelevController@getStudentAbsente',
]);

Route::post('profesor/get-student-absente-total', [
	'as'   => 'get-student-absente-total',
	'uses' => '\Libs\ParinteAbsenteelevController@getAbsenteTotal',
]);
