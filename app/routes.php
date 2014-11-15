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

	// Dev script interface
	Route::get('dev/script', function()
	{
		return View::make('admin.script.index');
	});

});


// Routes for API controllers
Route::group(['prefix' => 'api'], function()
{

	// Metadata controllers for media resources.
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
		
		// Get single definition using new definition model
		Route::resource('definitions', 'ApiDefinitionController');
	});

	// Route to get the definitions of specific words
	Route::post('words/definitions', 'ApiWordController@getMultipleWords');

	// Words
	Route::resource('words', 'ApiWordController');

	// Videos
	Route::resource('videos', 'ApiVideoController');
	
	// Scripts
	Route::resource('scripts', 'ApiScriptController');

	// Sample Quiz
	Route::get('quiz', function()
	{
		return Response::json([
			'status' => 'success',
			'data' => [
				'quiz_id' => 1,
				'question' => [
					'id' => 1,
					'description' => 'What is the definition of "forest"?',
					'definitions' => [
						['id' => 0, 'description' => 'a large tract of land covered with trees and underbush'],
						['id' => 1, 'description' => 'deserved reward of just desserts, usually unpleasant'],
						['id' => 2, 'description' => 'needless repitition of an idea'],
						['id' => 3, 'description' => 'the character or disposition of a community, group, person, etc.'],
					],
				],
			],
		]);
	});

});


// Routing group for static content.
Route::group(array('prefix' => 'content'), function()
{

	// Handle requests for video clips.
	Route::get('videos/{id}', 'VideoContentController@getVideo');

	// Handle requests for scripts.
	Route::get('scripts/{id}', 'ScriptContentController@getScript');
});


//video player
Route::get('/video/play/{id}', function($id)
{
    return View::make('player.player')->with("video_id",$id);
});


// Flashcard
Route::controller('flashcard', 'FlashcardController');


// Quiz View
Route::get('quiz', function()
{
	return View::make('quiz.main');
});

// CSRF Test Route
Route::any('test/csrf', ['before' => 'csrf', function() {}]);
