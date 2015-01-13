<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\InputDecorator;

/**
 * Concrete decorator that adds validation behavior to reminder quiz creation
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class ReminderQuizValidation extends InputDecorator {

	public function response($user, $input)
	{
		if (! $user)
		{
			return ['error', 'Must be logged in to create a quiz.', 401];
		}
		
		return parent::response($user, $input);
	}
}