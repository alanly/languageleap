<?php

use LangLeap\Accounts\User;

class ApiUserController extends \BaseController {
	
	public function postUpdatePassword() {
				
		$user = Auth::user();
		
		if (!$user)
		{
			$this->apiResponse('error', 'You must be logged in to send this request.', 400);
		}
		
		$newPassword = Input::get('new_password');
		$newPasswordAgain = Input::get('new_password_again');
		
		$confirmOldPassword = Input::get('confirm_old_password');
		
		if (strlen($newPassword) > 0 && Hash::check($newPassword, $user->password))
		{
			return $this->apiResponse('error', 'You may not enter the same password as your current one.', 400);
		}
		
		if (strlen($newPassword) > 0)
		{
			if ($newPassword != $newPasswordAgain)
			{
				return $this->apiResponse('error', 'Your new password and confirm password MUST be the same.', 400);
			}
		}
		
		if (strlen($newPassword) > 0 && !Hash::check($confirmOldPassword, $user->password))
		{
			return $this->apiResponse('error', 'Please enter your current password to make the changes.', 400);
		}
		
		$user->password = Hash::make($newPassword);
		$user->save();
		
		return $this->apiResponse('success', 'You have successfully changed your password.', 200);
	}
	
	public function postUpdateUserInfo() {
		
		$user = Auth::user();
		
		if (!$user)
		{
			$this->apiResponse('error', 'You must be logged in to send this request.', 400);
		}
		
		$validEmail = "/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
		
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
		
		if (strlen($newEmail) <= 0)
		{
			return $this->apiResponse('error', 'Please enter an email.', 400);
		}
		
		if (!preg_match($validEmail, $newEmail))
		{
			return $this->apiResponse('error', 'Please enter a valid email.', 400);
		}
		
		if (!Hash::check($currentPassword, $user->password))
		{
			return $this->apiResponse('error', 'Please enter your password to have your changes take effect.', 400);
		}
		
		$user->fill(array('first_name' => $newFirstName, 'last_name' => $newLastname, 'email' => $newEmail, 'language_id' => $newUserLanguage));
		$user->save();
		
		return $this->apiResponse('success', 'You have successfully updated your profile.', 200);
	}
}