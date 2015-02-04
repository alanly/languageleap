<?php

use LangLeap\Accounts\User;

class ApiUserController extends \BaseController {

	protected $user;
	
	public function postUpdatePassword() {
		
		$user = Auth::user();
		
		$newPassword = Input::get('new_password');
		
		if (strlen($newpassword) > 0 && !Hash::check($newPassword, $user->password))
		{
			return $this->apiResponse('error', 'You may not enter the same password as your current one!', 400);
		}
		
		$user->password = Hash::make($newPassword);
		$user->save();
		
		return $this->apiResponse('success', 'You have successfully changed your password.', 200);
	}
	
	public function postUpdateUserInfo() {
		
		$user = Auth::user();
		
		$currentFirstName = $user->first_name;
		$newFirstName = Input::get('first_name');
		
		$currentLastName = $user->last_name;
		$newLastName = Input::get('last_name');
		
		$currentEmail = $user->email;
		$newEmail = Input::get('new_email');
		
		$newUserLanguage = Input::get('language_id');
		
		$currentPassword = Input::get('current_password');
		
		if (strlen($newFirstName) <= 0 || strlen($newLastName) <= 0)
		{
			return $this->apiResponse('error', 'You must put your first and last name.', 400);
		}
		
		if ($currentEmail == $newEmail)
		{
			return $this->apiResponse('error', 'Please enter a different email.', 400);
		}
		
		if (!Hash::check($currentPassword, $user->password))
		{
			return $this->apiResponse('error', 'Please enter your password to have your changes take effect.', 400);
		}
		
		$user->fill(array('first_name' => $newFirstName, 'last_name' => $newLastname, 'language_id' => $newUserLanguage));
		$user->save();
		
		return $this->apiResponse('success', 'You have successfully updated your profile.', 200);
	}
}