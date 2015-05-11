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

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('articles', 'ArticlesController');
Route::resource('comments', 'CommentsController');
Route::get('export/{articles}',array('as'=>'articles.export','uses'=>'ArticlesController@export'));
Route::post('import',array('as'=>'articles.import','uses'=>'ArticlesController@import'));

