<?php namespace LangLeap\Core;

/**
 * Decorator pattern for the quiz to add logging, validation, etc.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
abstract class InputDecorator implements UserInputResponse
{
	protected $decoratedResponse;
	
	public function __construct(UserInputResponse $decoratedResponse)
	{
		$this->decoratedResponse = $decoratedResponse;
	}
	
	public function response($user_id, $input)
	{
		return $this->decoratedResponse->response($user_id, $input);
	}
}