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
// Accordion
Route::get('/', function(){
	return View::make('index');
});

//DO NOT FORGET TO ADD BEFORE => AUTH
Route::get('/admin', function()
{
	return View::make('admin.index');
});

Route::get('/admin/video', function()
{
	return View::make('admin.video.video');
});

Route::get('/admin/new/script', function(){
	return View::make('admin.video.script');
});

// Route to get the definitions of specific words
Route::post('/api/metadata/words/definitions', 'ApiWordController@getMultipleWords');


// Routes for API controllers
Route::group(array('prefix' => 'api',), function()
{

	// Media controllers
	Route::group(['prefix' => 'metadata'], function()
	{
		// Commercials
		Route::resource('commercials', 'ApiCommercialController');

		// Movies
		Route::resource('movies', 'ApiMovieController');

		// Shows (and Seasons and Episodes)
		Route::resource('shows', 'ApiShowController');
		Route::resource('shows.seasons', 'ApiSeasonController');
		Route::resource('shows.seasons.episodes', 'ApiEpisodeController');

		// Videos
		Route::resource('videos', 'ApiVideoController');
		
		// Words
		Route::resource('words', 'ApiWordController');
	});
});


//video player
Route::get('/video/play/{id}', function($id){
    return View::make('player.player')->with("video_id",$id);
});
