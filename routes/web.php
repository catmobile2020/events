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
            Route::get('{type}/users/{user}/destroy','UserController@destroy')->name('users.destroy');

            Route::resource('events','EventController');
            Route::get('events/{event}/destroy','EventController@destroy')->name('events.destroy')->middleware('admin');
            Route::get('events/{event}/feedback','EventController@feedback')->name('events.feedback');

            Route::resource('{event}/speakers','SpeakerController');
            Route::resource('{event}/talks','TalkController');
            Route::get('{event}/talks/{talk}/destroy','TalkController@destroy')->name('talks.destroy');
            Route::get('{event}/talks/{talk}/feedback','TalkController@feedback')->name('talks.feedback');

            Route::resource('{event}/posts','PostController');

            Route::group(['middleware'=>'admin'],function (){
                Route::resource('articles','ArticleController');
                Route::get('articles/{article}/destroy','ArticleController@destroy')->name('articles.destroy');

                Route::resource('banners','BannerController');
                Route::get('banners/{banner}/destroy','BannerController@destroy')->name('banners.destroy');

                Route::resource('partnerships','PartnershipController');
                Route::get('partnerships/{partnership}/destroy','PartnershipController@destroy')->name('partnerships.destroy');

                Route::resource('sponsors','SponsorController');
                Route::get('sponsors/{sponsor}/destroy','SponsorController@destroy')->name('sponsors.destroy');

                Route::resource('testimonials','TestimonialController');
                Route::get('testimonials/{testimonial}/destroy','TestimonialController@destroy')->name('testimonials.destroy');
            });

        });

});
