<?php namespace LangLeap\QuizUtilities;

use Lang;
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
			return ['error', Lang::get('controllers.quiz.create_no-auth'), 401];
		}
		
		return parent::response($user, $input);
	}

}