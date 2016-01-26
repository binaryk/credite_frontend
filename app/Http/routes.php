<?php

Route::get('/', 'HomeController@index'); 
Route::get('home',['as' => 'home','uses' => 'HomeController@index']);
Route::get('about',['as' => 'about','uses' => 'PagesController@about']);
Route::get('contact', ['as' => 'contact', 'uses'=>'PagesController@contact']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

	include(app_path() . '/~Libs/routes/administration.php');

    # Admin Dashboard

});
Route::get('partials/test', function(){
	return view('partial_test');
});
Route::get('url-get-airports',['as' => 'r_get_airports', 'uses' => 'HomeController@getAirports']);
include(app_path() . '/~Libs/routes/routes_booking_form.php'); 
include(app_path() . '/~Libs/routes/routes_booking_full_form.php'); 
include(app_path() . '/~Libs/routes/static.php');

// un mesaj frumos
