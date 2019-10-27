<?php

use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'/','namespace'=>'Admin','as'=>'admin.'],function (){
        Route::group(['prefix'=>'/'],function (){
            Route::get('/login','AuthController@index')->name('login');
            Route::post('/login','AuthController@login')->name('login');
            Route::get('/logout','AuthController@logout')->name('logout');
        });

        Route::group(['middleware'=>['auth:web']],function (){
            Route::get('/','HomeController@index')->name('home');
            Route::get('/profile','ProfileController@index')->name('profile');

            Route::resource('{type}/users','UserController');
            Route::get('{type}users/{user}/destroy','UserController@destroy')->name('users.destroy');

            Route::resource('events','EventController');
            Route::resource('{event}/speakers','SpeakerController');
            Route::resource('{event}/talks','TalkController');
            Route::get('{event}/talks/{talk}/destroy','TalkController@destroy')->name('talks.destroy');

            Route::resource('{event}/posts','PostController');
        });

});
