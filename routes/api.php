<?php

Route::group(['namespace' => 'Api'] ,function (){
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'AuthController@register')->name('api.register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
    });

    Route::group(['middleware'=>['jwt.auth','auth_type']],function (){
        Route::group(['prefix' => 'account'], function () {
            Route::get('/me','ProfileController@me');
            Route::post('/update','ProfileController@update')->name('api.account.update');
            Route::post('/update-password','ProfileController@updatePassword');
        });

        Route::group(['prefix' => 'events'], function () {
            Route::get('/','EventController@index');
            Route::get('/{event}','EventController@show');
            Route::get('/speakers/{speaker}','EventController@singleSpeaker');
            Route::get('/{event}/posts','PostController@index');
            Route::post('/{event}/posts','PostController@store');
            Route::post('/{event}/posts/{post}/update','PostController@update');
        });
    });
});
