<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\UserInputResponse;

/**
 * Decorator pattern for the quiz to add logging, validation, etc.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
abstract class QuizDecorator implements UserInputResponse
{
	protected $decoratedQuizFactory;
	
	public function __construct(UserInputResponse $decoratedQuizFactory)
	{
		$this->decoratedQuizFactory = $decoratedQuizFactory;
	}
	
	public function response($user_id, $input)
	{
		return $this->decoratedQuizFactory->response($user_id, $input);
	}
}