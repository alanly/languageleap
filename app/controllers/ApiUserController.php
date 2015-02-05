<?php

class ApiUserController extends \BaseController {

	public function __construct()
	{
		// Add the auth filter controller-wide.
		$this->beforeFilter('auth');
	}
	

	public function postUpdatePassword()
	{
		// Get the authenticated user instance.				
		$user = Auth::user();

		// Create a validator for our input.
		$validator = Validator::make(
			Input::all(),
			[
				'new_password' => 'required|confirmed|min:6',
				'password'     => 'required',
			]
		);

		// Handle failed input validation.
		if ($validator->fails())
		{
			return $this->apiResponse('error', $validator->messages(), 400);
		}
		
		// Handle invalid password.
		if (! Hash::check(Input::get('password'), $user->password))
		{
			return $this->apiResponse('error', 'Invalid password.', 401);
		}

		// Update the password field for the user account.		
		$user->password = Hash::make(Input::get('new_password'));
		
		// Attempt to update the user model.
		if (! $user->save())
		{
			return $this->apiResponse('error', $user->getErrors(), 400);
		}
		
		return $this->apiResponse('success', $user, 200);
	}
	

	public function postUpdateUserInfo()
	{
		
		$user = Auth::user();
		
		$currentFirstName = $user->first_name;
		$newFirstName = Input::get('first_name');
		
		$currentLastName = $user->last_name;
		$newLastName = Input::get('last_name');
		
		$currentEmail = $user->email;
		$newEmail = Input::get('new_email');
		
		$newUserLanguage = Input::get('language_id');
		
		$currentPassword = Input::get('current_password');
		
		if (!Hash::check($currentPassword, $user->password))
		{
			return $this->apiResponse('error', 'Please enter your password to have your changes take effect.', 400);
		}

		$user->fill(array('first_name' => $newFirstName, 'last_name' => $newLastName, 'email' => $newEmail, 'language_id' => $newUserLanguage));
		
		if (!$user->save())
		{
			return $this->apiResponse('error', $user->getErrors(), 400);
		}
		
		return $this->apiResponse('success', 'You have successfully updated your profile.', 200);
	}

}
