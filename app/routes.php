<?php

use LangLeap\Videos\Video;

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


// Route for setting the language.
Route::get('/language/{lang}', 'LanguageController@setLanguage');


// Routes for login and logout.
Route::group(['prefix' => 'login'], function()
{
	Route::get('/', 'AuthController@getLogin');
	Route::post('/', 'AuthController@postLogin');
});
Route::get('logout', 'AuthController@getLogout');


// Routes for registration and associated views.
Route::controller('register', 'RegistrationController');


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
	
	// new media upload
	Route::any('add-new-form-submit', 'FileUploadController@saveMedia');

	// store script
	Route::resource('save-script', 'ApiScriptController@store');

	// Dev quiz interface
	Route::get('quiz/new', function()
	{
		return View::make('admin.quiz.index')->with('videos', Video::All());
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

	// Query the definition API for a definition
	Route::resource('dictionaryDefinitions', 'ApiDictionaryController');

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

// Quiz View
Route::get('quiz', ['before' => 'auth', function()
{
	return View::make('quiz.main');
}]);

// Ranking Process
Route::controller('rank/quiz', 'RankQuizController');
Route::controller('rank/tutorial','TutorialQuizContentController');

// CSRF Test Route
Route::any('test/csrf', ['before' => 'csrf', function() {}]);

//User Level
Route::get('level', ['before' => 'auth', 'uses' => 'ApiUserLevelController@showLevel']);
