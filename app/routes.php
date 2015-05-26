<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',array('uses'=>'ArticlesController@index'));

Route::resource('articles', 'ArticlesController');
Route::resource('comments', 'CommentsController');
//Route::resource('users','UsersController',array('except'=> array('index','destroy')));
//Route::resource('sessions','SessionsController');
Route::get('export/{articles}',array('as'=>'articles.export','uses'=>'ArticlesController@export'));
Route::post('import',array('as'=>'articles.import','uses'=>'ArticlesController@import'));

//Route::get('/reset-password', array('as'=>'reset-password','uses'=>'UsersController@reset_password'));
//Route::post('/process-reset-password', array('as'=>'process-reset-password','uses'=>'UsersController@process_reset_password'));
//Route::get('/change-password/{forgot_token}',array('as'=>'change-passowrd','uses'=>'UsersController@change_password'));
//Route::post('/process-change-password/{forgot_token}',array('as'=>'process-change-password','uses'=>'UsersController@process_change_password'));

