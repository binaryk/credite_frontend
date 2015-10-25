<?php
$router->group(['namespace' => 'BookingFull'], function () use ($router)
{
	// get('quick-destination/{type?}/{destination?}/{switched?}', ['as' => 'booking.destination', 'uses' => 'BookingController@destination' ]);
	// po/st('quick-destination/online-pay', ['as' => 'booking.pay.online', 'uses' => 'BookingController@onlinePay' ]);
}); 

Route::get('booking-form', [
	'as'   => 'booking',
	'uses' => '\App\Http\Controllers\Booking\BookingFullController@getBookingForm',
]);

Route::post('booking-form-submit', [
	'as'   => 'boking_submit',
	'uses' => '\App\Http\Controllers\BookingFull\BookingFullController@submitBookingPrev',
]);