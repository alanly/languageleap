<?php

use LangLeap\Accounts\User;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 */
class AuthController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('guest', ['except' => 'getLogout']);
		$this->beforeFilter('auth', ['only' => 'getLogout']);
	}


	public function getLogin()
	{
		if (Auth::check()) return $this->intendedRedirect();

		return View::make('account.login');
	}


	public function postLogin()
	{
		$success = Auth::attempt(
			[
				'username' => Input::get('username'),
				'password' => Input::get('password')
			],
			Input::has('remember')
		);

		if (! $success)
		{
			// Redirect to login page with appropriate error messages.
			Session::flash('action.failed', true);
			Session::flash('action.message', Lang::get('auth.login.form_errors'));

			return Redirect::action('AuthController@getLogin')->withInput();
		}

		// Make sure the user is verified.
		if (! Auth::user()->is_confirmed)
		{
			Auth::logout();
			
			Session::flash('action.failed', true);
			Session::flash('action.message', Lang::get('auth.login.unverified'));

			return Redirect::action('AuthController@getLogin')->withInput();
		}

		// Set the language.
		Session::put('lang', Auth::user()->language);

		return $this->intendedRedirect();
	}


	public function getLogout()
	{
		Auth::logout();

		if (Auth::check())
		{
			Session::flash('action.failed', true);
			Session::flash('action.message', Lang::get('auth.logout.error'));

			return Redirect::to('/');
		}

		Session::flash('action.failed', false);
		Session::flash('action.message', Lang::get('auth.logout.success'));

		return Redirect::action('AuthController@getLogin');
	}


	protected function intendedRedirect()
	{
		return Redirect::intended((Auth::user()->is_admin) ? '/admin' : '/');
	}

}