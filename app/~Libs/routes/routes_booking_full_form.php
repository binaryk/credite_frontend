<?php
$router->group(['namespace' => 'BookingFull'], function () use ($router)
{
	// get('quick-destination/{type?}/{destination?}/{switched?}', ['as' => 'booking.destination', 'uses' => 'BookingController@destination' ]);
	// po/st('quick-destination/online-pay', ['as' => 'booking.pay.online', 'uses' => 'BookingController@onlinePay' ]);
}); 

Route::get('booking-form', [
	'as'   => 'booking',
	'uses' => '\App\Http\Controllers\BookingFull\BookingFullController@getBookingForm',
]);

Route::get('booking-form-submit/{from}/{to}', [
	'as'   => 'boking_submit_get',
	'uses' => '\App\Http\Controllers\BookingFull\BookingFullController@getBookingPrev',
]);

Route::post('booking-form-submit/{from}/{to}', [
	'as'   => 'boking_submit_post',
	'uses' => '\App\Http\Controllers\BookingFull\BookingFullController@postBookingPrev',
]);