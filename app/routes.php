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


// Routes for authentication views.
Route::controller('auth', 'AuthController');


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

	// Videos
	Route::resource('videos', 'ApiVideoController');
	
	// Scripts
	Route::resource('scripts', 'ApiScriptController');

	// Quiz
	Route::controller('quiz', 'ApiQuizController');

	// Registration
	Route::resource('users','ApiUserController');

});


// Routing group for static content.
Route::group(array('prefix' => 'content'), function()
{

	// Handle requests for video clips.
	Route::get('videos/{id}', 'VideoContentController@getVideo');

	// Handle requests for scripts.
	Route::get('scripts/{id}', 'ScriptContentController@getScript');

});


// Video Player
Route::get('/video/play/{id}', function($id)
{
	return View::make('player.player')->with('video_id', $id);
});


// Flashcard
Route::controller('flashcard', 'FlashcardController');


// Quiz View
Route::get('quiz', function()
{
	return View::make('quiz.main');
});

// Account Registration
Route::group(array('prefix' => 'register'), function()
{
	Route::get('/', function()
	{
		return View::make('account.registration.index');
	});

	Route::post('/', 'RegistrationController@store');

	Route::get('success', function()
	{
		return View::make('account.registration.success');
	});

	Route::get('verified', function()
	{
		return View::make('account.registration.verified');
	});

	Route::get('verify/{confirmationCode}', [
		'as' => 'confirmation_path',
		'uses' => 'RegistrationController@confirm'
	]);
});

// CSRF Test Route
Route::any('test/csrf', ['before' => 'csrf', function() {}]);