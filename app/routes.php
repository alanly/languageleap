<?php

use LangLeap\Levels\Level;
use LangLeap\Core\Language;
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

Route::get('/commercial/{id}', function($id)
{
	return View::make('commercial')->with("commercial_id", $id);
});

Route::get('/movie/{id}', function($id)
{
	return View::make('movie')->with("movie_id", $id);
});

Route::get('/episode/{id}', function($id)
{
	return View::make('episode')->with("episode_id", $id);
});

Route::get('/show/{id}', function($id)
{
	return View::make('show')->with("show_id", $id);
});

// TODO set this to be the index route
Route::get('/', function()
{
	return View::make('layout');
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
Route::group(['prefix' => 'admin', 'before' => 'admin'], function()
{
	/************************** NEW ANGULAR ADMIN ***************************/

	// New admin index
	Route::get('/', function()
	{
		return View::make('admin.index');
	});

	// This route should be used to reference pages
	// from AngularJS (eg. 'pages/manage-shows')
	Route::get('pages/{name}', function($name)
	{
		$view_path = 'admin.pages.' . $name;

		if (View::exists($view_path))
		{
			return View::make($view_path);
		}

		App::abort(404);
	});

	// This route should be used to reference partials 
	// from AngularJS (eg. 'partials/edit-show-modal')
	Route::get('partials/{name}', function($name)
	{
		$view_path = 'admin.partials.' . $name;

		if (View::exists($view_path))
		{
			return View::make($view_path);
		}

		App::abort(404);
	});

	Route::post('user', 'ApiAdminUserController@postActive');
});


// Routes for API controllers
Route::group(['prefix' => 'api'], function()
{

	// Metadata controllers for media resources.
	Route::group(['prefix' => 'metadata'], function()
	{

		// Commercials
		Route::resource('commercials', 'ApiCommercialController');
		Route::patch('commercials/update-script/{id}', 'ApiCommercialController@updateScript');
		Route::patch('commercials/save-timestamps/{id}', 'ApiCommercialController@saveTimestamps');

		// Movies
		Route::resource('movies', 'ApiMovieController');
		Route::patch('movies/update-script/{id}', 'ApiMovieController@updateScript');
		Route::patch('movies/save-timestamps/{id}', 'ApiMovieController@saveTimestamps');

		// Shows (and Seasons and Episodes)
		Route::resource('shows', 'ApiShowController');
		Route::resource('shows.seasons', 'ApiSeasonController');
		Route::resource('shows.seasons.episodes', 'ApiEpisodeController');
		Route::patch('shows/update-script/{id}', 'ApiShowController@updateScript');
		Route::patch('shows/save-timestamps/{id}', 'ApiShowController@saveTimestamps');
		
		//Episode without show/season identifiers
		Route::get('episode/{id}', 'ApiEpisodeController@showEpisode');

		// Get single definition using new definition model
		Route::resource('definitions', 'ApiDefinitionController');

		// Recommendations
		Route::resource('recommended', 'ApiRecommendedVideosController');
		
		// Filtration
		Route::resource('filter', 'ApiFilterController');
	});

	// Query the definition API for a definition
	Route::resource('dictionaryDefinitions', 'ApiDictionaryController');

	// Videos
	Route::resource('videos', 'ApiVideoController');
	Route::post('videos/timestamps/{id}', 'ApiVideoController@postTimestamps');
	Route::controller('videos/cut', 'ApiCutVideoController');

	// Scripts
	Route::resource('scripts', 'ApiScriptController');

	// Scripts
	Route::post('parse/script', 'ApiParseScriptController@postIndex');

	// Update user info
	Route::controller('users','ApiUserController');
	
	// Review words
	Route::controller('review', 'ApiReviewWordsController');
	
	// Level progress
	Route::controller('levelProgress', 'ApiLevelProgressController');

	//Api routes with auth filter
	Route::group(array('before' => 'auth'), function() {  
		
		// Viewing History     
		Route::controller('history', 'ApiViewingHistoryController');

		// Quiz
		Route::controller('quiz', 'ApiQuizController');
	});
});


// Routing group for static content.
Route::group(array('prefix' => 'content'), function()
{

	// Handle requests for video clips.
	Route::get('videos/{id}', 'VideoContentController@getVideo');

	// Handle requests for scripts.
	Route::get('scripts/{id}', 'ScriptContentController@getScript');

	// Handle requests for media images.
	Route::get('images/{model}/{id}', 'ImageContentController@getImage');

});


// Video Player
Route::get('/video/play/{id}', ['before' => 'auth'] ,function($id)
{
	return View::make('player.player')->with('video_id', $id);
});


// Quiz View
Route::get('quiz', ['before' => 'auth', function()
{
	return View::make('quiz.main');
}]);

// Recommended Videos View
Route::get('/recommended', function()
{
	return View::make('recommended');
});

// Ranking Process
Route::controller('rank', 'RankQuizController');


// CSRF Test Route
Route::any('test/csrf', ['before' => 'csrf', function() {}]);


// Routes for user panel controllers
Route::group(['prefix' => 'user', "before" => "auth"], function()
{
	//User Level
	Route::get('wordBank', 'ApiUserPanelController@showSelectedWords');

	//User Level
	Route::get('level', 'ApiUserPanelController@showLevel');

	//User Info
	Route::get('info', 'ApiUserPanelController@showInfo');
	
	//User quiz history
	Route::get('history', 'ApiUserPanelController@showQuizHistory');
});

Route::any('queue/recieve', function()
{
	return Queue::marshal();
});
