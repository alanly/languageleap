<?php namespace LangLeap\Core;

use LangLeap\Accounts\User;

/**
 * Decorator pattern for the quiz to add logging, validation, etc.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
abstract class InputDecorator implements UserInputResponse {

	protected $decoratedResponse;
	
	public function __construct(UserInputResponse $decoratedResponse)
	{
		$this->decoratedResponse = $decoratedResponse;
	}
	
	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		return $this->decoratedResponse->response($user, $input);
	}

}
