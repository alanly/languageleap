<?php namespace LangLeap\Accounts;

/**
 * Inspired and modified from `LaravelIO/laravel.io`.
 * @author Alan Ly <hello@alan.ly>
 */
interface UserUpdaterListener {

	public function userUpdated($user);

	public function userValidationError($errors);
	
}
