<?php

use LangLeap\Accounts\User;

class ApiAdminUserController extends \BaseController {

	public function __construct()
	{
		//Should check if user is admin
		$this->beforeFilter('auth');
	}

	public function postActive()
	{
		$user = User::find(Input::get('user_id'));

		if(! $user)
		{
			return $this->apiResponse('error', Lang::get('controllers.admin.user.not_found'), 404);
		}
		
		$user->is_active = !$user->is_active;

		if(! $user->save())
		{
			return $this->apiResponse('error', Lang::get('controllers.admin.user.error_save'), 400);
		}

		// Update user and return the given response.
		return $this->apiResponse('success', Lang::get('controllers.admin.user.sucess'), 200);
	}

}
