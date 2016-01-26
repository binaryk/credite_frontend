<?php

Route::get('administration', [
	'as'   => 'administration',
	'uses' => '\App\Http\Controllers\AdminController@index',
]);

Route::get('users-view', [
	'as' => 'users-view',
	'uses' => '\App\Http\Controllers\AdminController@users'
]);

Route::get('admin-reviews', [
	'as' => 'admin_reviews',
	'uses' => '\App\Http\Controllers\AdminCommentsController@index'
]);

Route::post('comment-validation', [
	'as' => 'comment.validation',
	'uses' => '\App\Http\Controllers\AdminCommentsController@validation'
]);

Route::get('admin-request', [
	'as' => 'admin_requests',
	'uses' => '\App\Http\Controllers\AdminRequestController@index'
]);

Route::get('admin-request/response/{id}', [
	'as' => 'admin_requests_response',
	'uses' => '\App\Http\Controllers\AdminRequestController@response'
]);

Route::post('admin-request/response/{id}', [
	'as' => 'admin_requests_response_post',
	'uses' => '\App\Http\Controllers\AdminRequestController@postResponse'
]);