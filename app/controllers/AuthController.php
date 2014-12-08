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
		if (Auth::check()) return $this->authRedirect();

		return View::make('auth.login');
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
			return Redirect::action('AuthController@getLogin')
				->with("action.failed", true)
				->with("action.message", "Invalid username or password");
		}

		return $this->authRedirect();
	}


	public function getLogout()
	{
		Auth::logout();

		$failed = Auth::check();

		if ($failed)
		{
			return Redirect::back()
				->with('action.failed', true)
				->with('action.message', 'Unable to logout. Please contact an administrator.');
		}

		return Redirect::action('AuthController@getLogin')
			->with('action.failed', false)
			->with('action.message', 'You have been logged out.');
	}


	protected function authRedirect()
	{
		return Redirect::intended((Auth::user()->is_admin) ? '/admin' : '/');
	}

}