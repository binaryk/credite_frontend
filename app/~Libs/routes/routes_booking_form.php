<?php
$router->group(['namespace' => 'Booking'], function () use ($router)
{
	get('quick-destination/{type?}/{destination?}/{switched?}', ['as' => 'booking.destination', 'uses' => 'BookingController@destination' ]);
	post('quick-destination/{type?}/{destination?}/{switched?}', ['as' => 'booking.destination', 'uses' => 'BookingController@onlinePay' ]);
	post('quick-destination/online-pay', ['as' => 'booking.pay.online', 'uses' => 'BookingController@onlinePay' ]);

	get('request-response-destination/{request}/{response}', ['as' => 'booking.from_request', 'uses' => 'BookingController@fromRequest' ]);
	post('request-response-destination/{request}/{response}', ['as' => 'booking.from_request.post', 'uses' => 'BookingController@onlinePay' ]);
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

Route::post('booking_post_form', [
	'as' => 'booking_post_form', 
	'uses' => '\App\Http\Controllers\Booking\BookingController@postForm'
]);