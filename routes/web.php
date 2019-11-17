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
            Route::get('/notifications','HomeController@notifications');
            Route::get('/notifications/{notification}','HomeController@readNotification');
            Route::get('/notifications/read/all','HomeController@readAllNotification');
            Route::get('/profile','ProfileController@index')->name('profile');
            Route::post('/profile','ProfileController@update')->name('profile.update');

            Route::resource('{type}/users','UserController');
            Route::get('{type}/users/{user}/destroy','UserController@destroy')->name('users.destroy');

            Route::resource('events','EventController');
            Route::get('events/{event}/destroy','EventController@destroy')->name('events.destroy')->middleware('admin');
            Route::get('events/{event}/analysis','EventController@analysis')->name('events.analysis');
            Route::get('events/{event}/feedback','EventController@feedback')->name('events.feedback');
            Route::get('chat/{event}','ChatController@index')->name('events.chat');
            Route::get('chat/get-messages/{event}','ChatController@getMessages');
            Route::post('chat/send-message','ChatController@sendMessage');
            Route::post('chat/delete-message/{message}','ChatController@deleteMessage');

            Route::resource('{event}/speakers','SpeakerController');
            Route::resource('{event}/talks','TalkController');
            Route::get('{event}/talks/{talk}/destroy','TalkController@destroy')->name('talks.destroy');
            Route::get('{event}/talks/{talk}/feedback','TalkController@feedback')->name('talks.feedback');
            Route::get('feedback/{feedback}','TalkController@deleteFeedback')->name('feedback.delete');

            Route::resource('{event}/posts','PostController');
            Route::get('{post}/comments','PostController@comments')->name('posts.comments.index');
            Route::get('{post}/comments/{comment}','PostController@deleteComment')->name('posts.comments.destroy');

            Route::resource('sponsors','SponsorController');
            Route::get('sponsors/{sponsor}/destroy','SponsorController@destroy')->name('sponsors.destroy');

            Route::resource('partnerships','PartnershipController');
            Route::get('partnerships/{partnership}/destroy','PartnershipController@destroy')->name('partnerships.destroy');

            Route::resource('{event}/testimonials','TestimonialController');
            Route::get('{event}/testimonials/{testimonial}/destroy','TestimonialController@destroy')->name('testimonials.destroy');

            Route::group(['middleware'=>'admin'],function (){
                Route::resource('articles','ArticleController');
                Route::get('articles/{article}/destroy','ArticleController@destroy')->name('articles.destroy');

                Route::resource('banners','BannerController');
                Route::get('banners/{banner}/destroy','BannerController@destroy')->name('banners.destroy');

                Route::get('analysis','AnalysisController@index')->name('analysis.index');

            });

        });

});
