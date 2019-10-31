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

            Route::post('/{event}/join','EventController@joinToEvent');
            Route::post('/{event}/invite','EventController@inviteToEvent');
            Route::post('/{event}/join-by-invitation-code','EventController@joinToEventByCode');

            Route::get('/{event}/posts','PostController@index');
            Route::post('/{event}/posts','PostController@store');
            Route::post('/{event}/posts/{post}/update','PostController@update');

            Route::post('/{post}/comments','CommentController@store');
            Route::put('/{post}/comments/{comment}','CommentController@update');

            Route::get('/{event}/feedback','EventController@eventFeedback');
            Route::post('/{event}/feedback','EventController@storeEventFeedback');

            Route::apiResource('/{event}/polls','PollController');
            Route::post('/{event}/polls/add-vote','PollController@addVote');

            Route::get('/talks/{talk}/feedback','EventController@talkFeedback');
            Route::post('/talks/{talk}/feedback','EventController@storeTalkFeedback');
        });
    });
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/','ArticleController@index');
        Route::get('/{article}','ArticleController@show');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/','BannerController@index');
        Route::get('/{banner}','BannerController@show');
    });

    Route::group(['prefix' => 'sponsors'], function () {
        Route::get('/','SponsorController@index');
        Route::get('/{sponsor}','SponsorController@show');
    });
    Route::group(['prefix' => 'partnerships'], function () {
        Route::get('/','PartnershipController@index');
        Route::get('/{partnership}','PartnershipController@show');
    });
    Route::group(['prefix' => 'testimonials'], function () {
        Route::get('/','TestimonialController@index');
        Route::get('/{testimonial}','TestimonialController@show');
    });
});
