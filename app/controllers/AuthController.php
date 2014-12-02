<?php

use LangLeap\Accounts\User;

/**
* @author Thomas Rahn <thomas@rahn.ca>
*/
class AuthController extends BaseController{

	/**
	 *	Return the login page
	 */
	public function getLogin()
	{
		return View::make('auth.login');
	}

	/**
	 *	This function will attempt to login with a username and password. 
	 *	If the username password combination is successfull it will redirect to the index page. 
	 *	Otherwise returns back the same page with the appropriate error message
	 */
	public function postLogin()
	{
		$success = Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')), Input::has('remember'));

		if($success)
		{
			return Redirect::intended('/');
		}
		else
		{
			return Redirect::route('login')->with("action.failed", false)->with("action.message", "Invalid username or password");
		}
	}

	/**
	 *	Attempt to logout.
	 */
	public function getLogout()
	{
		Auth::logout();

		$success = ! Auth::check();

		return $this->apiResponse(
			$success,
			($success === false) ? "Logout has failed" : "Successfully logged out"
		);

	}
}