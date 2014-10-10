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


//DO NOT FORGET TO ADD BEFORE => AUTH
Route::get('/admin', function()
{
	return View::make('admin.index');
});
Route::get('/admin/video', function()
{
	return View::make('admin.video.video');
});
// Accordion
Route::controller('Accordion', 'AccordionController');


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
	});
});

