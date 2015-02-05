<?php

use LangLeap\Accounts\UserUpdaterListener;

class ApiUserController extends \BaseController implements UserUpdaterListener {

	public function __construct()
	{
		// Add the auth filter controller-wide.
		$this->beforeFilter('auth');
	}


	public function putUser()
	{
		// Get the authenticated user.
		$user = Auth::user();

		// Create a user updater instance.
		$userUpdater = App::make('LangLeap\Accounts\UserUpdater');

		// Update user and return the given response.
		return $userUpdater->update($user, Input::all(), $this);
	}


	public function userUpdated($user)
	{
		return $this->apiResponse('success', $user);
	}


	public function userValidationError($errors)
	{
		return $this->apiResponse('error', $errors, 400);
	}

}
