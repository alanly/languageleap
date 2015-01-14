<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\InputDecorator;

/**
 * Concrete decorator that adds validation behavior to reminder quiz creation
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class ReminderQuizValidation extends InputDecorator {

	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		if (! $user)
		{
			return ['error', 'Must be logged in to create a quiz.', 401];
		}
		
		return parent::response($user, $input);
	}

}