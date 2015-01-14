<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\InputDecorator;
use LangLeap\Core\UserInputResponse;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;

/**
 * Concrete decorator that adds validation behavior to Quiz creation
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class QuizAnswerValidation extends InputDecorator {
	
	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		// Ensure that there is a user
		if (! $user)
		{
			return ['error', 'Must be logged in to answer a quiz question', 401];
		}
		
		// Ensure that the Question exists, else return a 404.
		$videoquestion = null;
		if (isset($input['videoquestion_id']))
		{
			$videoquestion_id = $input['videoquestion_id'];
			$videoquestion = VideoQuestion::find($videoquestion_id);
		}
		if (! $videoquestion)
		{
			return [
				'error',
				"Question {$videoquestion_id} not found.",
				404
			];
		}

		// Ensure the selected definition exists, otherwise return a 400.
		$selectedId = isset($input['selected_id']) ? $input['selected_id'] : null;
		if (! $selectedId)
		{
			return [
				'error',
				"The selected definition {$selectedId} is invalid",
				400
			];
		}

		// Ensure the quiz exists
		$quiz = null;
		if (isset($input['quiz_id']))
		{
			$quiz_id = $input['quiz_id'];
			$quiz = Quiz::find($quiz_id);
		}
		if (! $quiz)
		{
			return ['error', "Quiz {$quiz_id} not found.", 404];
		}
		else if ( ($quiz->user_id != $user->id) && ! $user->is_admin )
		{
			return ['error', "Not authorized to answer questions for quiz {$quiz_id}", 401];
		}
		
		return parent::response($user, $input);
	}

}
