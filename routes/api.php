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
            Route::get('/my-tickets','ProfileController@myTickets');
        });

        Route::group(['prefix' => 'events'], function () {
            Route::get('/','EventController@index');
            Route::get('/{event}','EventController@show');
            Route::get('/speakers/{speaker}','EventController@singleSpeaker');

            Route::post('/{event}/join','EventController@joinToEvent');
            Route::post('/{event}/invite','EventController@inviteToEvent');
            Route::post('/{event}/join-by-invitation-code','EventController@joinToEventByCode');
            Route::get('/{event}/chat','ChatController@chat');
            Route::post('/{event}/chat','ChatController@sendMessage');

            Route::post('/{event}/booking-ticket','TicketController@booking');

            Route::apiResource('/{event}/posts','PostController');
//            Route::get('/{event}/posts','PostController@index');
//            Route::post('/{event}/posts','PostController@store');
//            Route::get('/{event}/posts/{post}','PostController@show');
            Route::post('/{event}/posts/{post}/update','PostController@update');
//            Route::delete('/{event}/posts/{post}','PostController@destroy');

            Route::apiResource('/{post}/comments','CommentController');
//            Route::get('/{post}/comments','CommentController@index');
//            Route::post('/{post}/comments','CommentController@store');
//            Route::put('/{post}/comments/{comment}','CommentController@update');
//            Route::delete('/{post}/comments/{comment}','CommentController@destroy');

            Route::get('/{event}/feedback','EventController@eventFeedback');
            Route::post('/{event}/feedback','EventController@storeEventFeedback');

            Route::get('/{event}/testimonials','TestimonialController@index');
            Route::get('/{event}/sponsors','SponsorController@index');
            Route::get('/{event}/partnerships','PartnershipController@index');

            Route::apiResource('/{event}/polls','PollController');
            Route::post('/{event}/polls/{option}/add-vote','PollController@addVote');

            Route::get('/talks/{talk}/feedback','EventController@talkFeedback');
            Route::post('/talks/{talk}/feedback','EventController@storeTalkFeedback');

            Route::get('/custom/search','EventController@customSearch');
        });
        Route::get('/my-events','EventController@myEvents');

        Route::get('/{speaker}/questions','LiveController@questions');
        Route::post('/live/{speaker}/questions','LiveController@sendQuestion');


        Route::get('/rooms','RoomController@messenger');
        Route::post('/rooms','RoomController@createRoom');
        Route::post('/rooms/{room}/send-message','RoomController@sendMessage');

    });
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/','ArticleController@index');
        Route::get('/{article}','ArticleController@show');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/','BannerController@index');
        Route::get('/{banner}','BannerController@show');
    });

});
