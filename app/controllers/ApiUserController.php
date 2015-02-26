<?php

use LangLeap\Accounts\User;
use LangLeap\Accounts\UserUpdaterListener;

class ApiUserController extends \BaseController implements UserUpdaterListener {

	protected $users;

	public function __construct(User $users)
	{
		// Add the auth filter controller-wide.
		$this->beforeFilter('auth');
		$this->users = $users;
	}

	public function getIndex()
	{
		$user = Auth::user();

		if($user->is_admin)
		{
			return $this->apiResponse('success', $this->users->all(), 200);
		}
		else
		{
			return $this->apiResponse('error', Lang::get('controller.user.unauthorized'), 401);
		}
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
		if ($errors instanceof Illuminate\Support\MessageBag)
			$errors = $errors->all();

		return $this->apiResponse('error', $errors, 400);
	}

}
