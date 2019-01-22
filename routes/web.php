<?php

use App\Shortener;
use Illuminate\Http\Request;

// HOME
Route::get('/', 'ShortenedURL@index');

// AJAX NAMECHECK FUNCTION
Route::post('/namecheck', 'ShortenedURL@nameCheck');

// AJAX INSERT FUNCTION (SAVE BUTTON)
Route::post('/insert', 'ShortenedURL@insert');

// REGEX WILDCARD TO ANY OTHER ROUTE PARAMETER
Route::get('/{shortened_url}', 'ShortenedURL@redirect')->where(['shortened_url' => '.+']);

