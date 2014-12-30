<?php namespace LangLeap\Core;

/**
 * An interface that hides operations for user input response
 *
 * @author Quang Tran <tran.quang@live.com>
 */
interface UserInputResponse
{
	/**
	* Return an array with the parameters for BaseController::apiResponse in the same order
	*
	* @param int $user_id
	* @param array $input
	*/
	public function response($user_id, $input);
}