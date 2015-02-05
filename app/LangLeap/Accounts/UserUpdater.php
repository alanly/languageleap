<?php namespace LangLeap\Accounts;

use Hash, Validator;

/**
 * Inspired and modified from `LaravelIO/laravel.io`.
 * @author Alan Ly <hello@alan.ly>
 */
class UserUpdater {

	public function update(User $user, array $data, UserUpdaterListener $listener)
	{
		// Check our local validator.
		if (($errors = $this->validateData($data, $user)))
		{
			return $listener->userValidationError($errors);
		}

		// Update the user.
		return $this->updateUser($user, $listener, $data);
	}


	private function validateData(array $data, User $user)
	{
		$validator = Validator::make(
			$data,
			[
				'new_password' => 'confirmed|min:6',
				'password'     => 'required',
			]
		);

		// Handle invalid input values.
		if ($validator->fails()) return $validator->errors();

		// Handle invalid password.
		if (! Hash::check($data['password'], $user->password))
		{
			return ['password' => "Invalid password for user {$user->id}."];
		}

		return null;
	}


	private function updateUser(User $user, UserUpdaterListener $listener, array $data)
	{
		// Remove the password value from the data array so that we don't
		// overwrite the existing hash.
		unset($data['password']);

		// Handle a new password update.
		if (isset($data['new_password']))
		{
			$data['password'] = Hash::make($data['new_password']);
		}

		$user->fill($data);

		// Handle model validation failure.
		if (! $user->save())
		{
			return $listener->userValidationError($user->getErrors());
		}

		return $listener->userUpdated($user);
	}
	
}
