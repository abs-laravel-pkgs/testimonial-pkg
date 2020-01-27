<?php
Route::group(['namespace' => 'Abs\TestimonialPkg\Api', 'middleware' => ['api']], function () {
	Route::group(['prefix' => 'testimonial-pkg/api'], function () {
		Route::group(['middleware' => ['auth:api']], function () {
			// Route::get('taxes/get', 'TaxController@getTaxes');
		});
	});
});