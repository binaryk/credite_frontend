<?php
$router->group(['namespace' => 'Booking'], function () use ($router)
{
	get('quick-destination/{type?}/{destination?}', ['as' => 'booking.destination', 'uses' => 'BookingController@destination' ]);
});

Route::post('commons/get-form', [
	'as'   => 'r_get_form',
	'uses' => '\App\Http\Controllers\Booking\BookingController@getFormular',
]);

Route::get('quick-booking-submit', [
	'as'   => 'quick_booking_submit',
	'uses' => '\App\Http\Controllers\Booking\BookingController@submitGetFormular',
]);

Route::get('booking-form', [
	'as'   => 'booking_form',
	'uses' => '\App\Http\Controllers\Booking\BookingController@getBookingForm',
]);



