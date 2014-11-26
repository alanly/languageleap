<?php

use LangLeap\Accounts\User;

/**
* @author Thomas Rahn <thomas@rahn.ca>
* 
*/
class AuthController extends BaseController{

	public function getLogin()
	{
		return View::make('auth.login');
	}

	public function postLogin()
	{
		$success = Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), Input::has('remember')));
		
		if($sucess && Auth::check())
		{


		}		

		return $this->apiResponse(
			'error',
			'Login has failed'
		);
	}

	public function getLogout()
	{
		Auth::logout();

		$success = ! Auth::check();

		return $this->apiResponse(
			! $success,
			($success === false) ? "Logout has failed" : "Successfully logged out"
		);

	}
}