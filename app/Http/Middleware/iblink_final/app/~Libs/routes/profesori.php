<?php

/** 
 * Clasele mele
 **/

Route::get('profesor/clasele-mele/{id?}', [
	'as'   => 'index-profesor-clasele-mele',
	'uses' => '\Libs\ProfesorClaselemeleController@index',
]);

Route::get('profesor/clasele-mele-row-sources/{id?}', [
	'as'   => 'index-profesor-clasele-mele-row-sources',
	'uses' => '\Libs\ProfesorClaselemeleController@rows' 
]);

/** 
 * Clasa Management
 **/

Route::get('profesor/clasa/{clasa_id}/{id?}', [
	'as'   => 'index-profesor-clasa',
	'uses' => '\Libs\ProfesorClasaController@index',
]);

Route::get('profesor/clasa-row-sources/{clasa_id}/{id?}', [
	'as'   => 'index-profesor-clasa-row-sources',
	'uses' => '\Libs\ProfesorClasaController@rows' 
]);

/**
 * Informatii elev
 **/
Route::post('profesor/clasa/get-student-info-form', [
	'as' => 'get-student-info-form',
	'uses' => '\Libs\ProfesorClasaController@getStudentInfoForm' 
]);

/**
 * Activitate plus/minus
 **/
Route::post('profesor/clasa/save-activitate-elev', [
	'as' => 'save-activitate-elev',
	'uses' => '\Libs\ProfesorClasaController@saveActivitate' 
]);

/**
 * Absente toata clasa
 **/

Route::post('profesor/clasa/show-absente-clasa-form', [
	'as' => 'show-absente-clasa-form',
	'uses' => '\Libs\ProfesorClasaController@getAbsenteClasaForm' 
]);

Route::post('profesor/clasa/insert-absente-clasa', [
	'as' => 'insert-absente-clasa',
	'uses' => '\Libs\ProfesorClasaController@insertAbsenteClasa' 
]);

/**
 * Absente elev
**/
Route::post('profesor/clasa/get-student-add-absence-form', [
	'as' => 'get-student-add-absence-form',
	'uses' => '\Libs\ProfesorClasaController@getStudentAddabsentaForm' 
]);

Route::post('profesor/clasa/save-absenta-elev', [
	'as' => 'save-absenta-elev',
	'uses' => '\Libs\ProfesorClasaController@saveAbsenta' 
]);

/**
 * Note toata clasa
 **/
Route::post('profesor/clasa/show-noteaza-clasa-form', [
	'as' => 'show-noteaza-clasa-form',
	'uses' => '\Libs\ProfesorClasaController@getNoteazaClasaForm' 
]);

Route::post('profesor/clasa/insert-note-clasa', [
	'as' => 'insert-note-clasa',
	'uses' => '\Libs\ProfesorClasaController@insertNoteClasa' 
]);

/**
 * Note un elev
 **/
Route::post('profesor/clasa/get-student-add-nota-form', [
	'as' => 'get-student-add-nota-form',
	'uses' => '\Libs\ProfesorClasaController@getStudentAddnotaForm' 
]);

Route::post('profesor/clasa/save-nota-elev', [
	'as' => 'save-nota-elev',
	'uses' => '\Libs\ProfesorClasaController@saveNota' 
]);

/**
 * Mesaje toata clasa
 **/
Route::post('profesor/clasa/show-mesaje-clasa-form', [
	'as' => 'show-mesaje-clasa-form',
	'uses' => '\Libs\ProfesorClasaController@getMesajeClasaForm' 
]);

Route::post('profesor/clasa/insert-mesaje-clasa', [
	'as' => 'insert-mesaje-clasa',
	'uses' => '\Libs\ProfesorClasaController@insertMesajeClasa' 
]);

/**
 * Mesaj elev
 **/
Route::post('profesor/clasa/get-student-add-message-form', [
	'as' => 'get-student-add-message-form',
	'uses' => '\Libs\ProfesorClasaController@getStudentAddmessageForm' 
]);

Route::post('profesor/clasa/save-mesaj-elev', [
	'as' => 'save-mesaj-elev',
	'uses' => '\Libs\ProfesorClasaController@saveMesaj' 
]);

/**
 * Clasa care umple datatable
 **/
Route::post('profesor/clasa/get-clasa-informations', [
	'as' => 'get-clasa-informations',
	'uses' => '\Libs\ProfesorClasaController@getClasaInformations' 
]);
