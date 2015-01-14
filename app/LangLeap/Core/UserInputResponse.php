<?php namespace LangLeap\Core;

use LangLeap\Accounts\User;

/**
 * An interface that hides operations for user input response
 *
 * @author Quang Tran <tran.quang@live.com>
 */
interface UserInputResponse {

	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input);

}