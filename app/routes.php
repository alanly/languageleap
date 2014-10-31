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
Route::get('/', function()
{
	return View::make('index');
});


// Route grouping for administration interface.
Route::group(['prefix' => 'admin'], function()
{

	// Interface index
	Route::get('/', function()
	{
		return View::make('admin.index');
	});

	// Video interface
	Route::get('video', function()
	{
		return View::make('admin.video.video');
	});

	// Script interface
	Route::get('new/script', function()
	{
		return View::make('admin.video.script');
	});

});


// Routes for API controllers
Route::group(['prefix' => 'api'], function()
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

		// Route to get the definitions of specific words
		Route::post('words/definitions', 'ApiWordController@getMultipleWords');
		
		// Words
		Route::resource('words', 'ApiWordController');

		// Flashcard
		Route::resource('flashcard', 'ApiFlashcardController');
	});

});


// Routing group for static content.
Route::group(array('prefix' => 'content'), function()
{

	// Handle requests for video clips.
	Route::get('videos/{id}', 'VideoContentController@getVideo');

});


//video player
Route::get('/video/play/{id}', function($id)
{
    return View::make('player.player')->with("video_id",$id);
});


// Flashcard
Route::controller('flashcard', 'FlashcardController');
