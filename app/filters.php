<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	/**
	 * Store the current CSRF token in a cookie.
	 */
	if (! App::runningUnitTests())
	{
		setcookie('CSRF-TOKEN', csrf_token());
	}

	App::setlocale(Session::get('lang','en'));
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}

		// Redirect to login with an unauthorized message
		Session::flash('action.failed', true);
		Session::flash('action.message', Lang::get('auth.login.unauthorized'));
		return Redirect::guest('/login');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


Route::filter('admin', function()
{
	if (! Auth::user() || ! Auth::user()->isAdmin())
	{
		return Response::make('Unauthorized', 401);
	}
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	// Fetch token from input fields; if null, fetch token from request header.
	$token = Input::get('_token', Request::header('X-CSRF-TOKEN'));

	if (Session::token() !== $token)
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| AJAX Request Filter
|--------------------------------------------------------------------------
|
| The AJAX request filter checks if the request is being performed via AJAX
| methods. Note that this is not a guarantee that the request is being made via
| AJAX, it simply checks the request headers, which can always be specified by
| the client at will.
|
*/

Route::filter('ajax', function()
{
	if (! Request::ajax() && ! Request::isJson())
	{
		return Response::make('Method Not Allowed', 405);
	}
});
