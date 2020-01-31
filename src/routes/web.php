<?php

Route::group(['namespace' => 'Abs\TestimonialPkg', 'middleware' => ['web', 'auth'], 'prefix' => 'testimonial-pkg'], function () {
	//TESTIMONIALS
	Route::get('/testimonials/get-list', 'TestimonialController@getTestimonialList')->name('getTestimonialList');
	Route::get('/testimonial/get-form-data/', 'TestimonialController@getTestimonialFormData')->name('getTestimonialFormData');
	Route::post('/testimonial/save', 'TestimonialController@saveTestimonial')->name('saveTestimonial');
	Route::get('/testimonial/delete/{id}', 'TestimonialController@deleteTestimonial')->name('deleteTestimonial');
});

Route::group(['namespace' => 'Abs\TestimonialPkg', 'middleware' => ['web', 'auth'], 'prefix' => 'testimonial-pkg'], function () {
	//TESTIMONIALS
	Route::get('/testimonials/get', 'TestimonialController@getTestimonials')->name('getTestimonials');
});