<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
    ],
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user', 'AuthController@user');

    Route::get('/calendars', 'UserController@calendars');
    Route::get('/calendars/events', 'UserController@calendarsWithEvents');
    Route::get('/events', 'UserController@calendarsWithEvents');
});

Route::group([
    'middleware' => [
        'jwt.auth',
    ],
], function () {

    Route::post('/calendar/create', 'CalendarController@create');
    Route::post('/calendar/{id}/edit', 'CalendarController@edit');
    Route::delete('/calendar/{id}/remove', 'CalendarController@remove');




    Route::post('/calendar/{id}/event/create', 'EventController@create');
    Route::post('/event/{id}/edit', 'EventController@edit');
    Route::delete('/event/{id}/remove', 'EventController@remove');
});
Route::get('/calendar/{id}/events', 'CalendarController@events');


Route::get('/event/{id}', 'EventController@event');
Route::get('/calendar/{id}', 'CalendarController@calendar');