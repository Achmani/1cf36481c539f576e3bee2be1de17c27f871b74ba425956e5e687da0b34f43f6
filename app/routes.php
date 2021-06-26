<?php

use App\Helpers\Route;

Route::get('/getTree/{id}', 'HomeController@getTree');
Route::get('/getParent/{id}', 'HomeController@getParent');
Route::get('/getChildren/{id}', 'HomeController@getChildren');
