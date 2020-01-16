<?php

Route::group(['prefix' => 'v1'], function () {
	Route::group(['prefix' => 'stations'], function () {
		Route::get('/', 'StationController@index');
		Route::get('/{station}', 'StationController@show');
		Route::post('/', 'StationController@store');
		Route::patch('/{station}', 'StationController@update');
		Route::delete('/{station}', 'StationController@destroy');
	});
});


