<?php namespace LangLeap\QuizUtilities;

use Lang;
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
		$quizId = isset($input['quiz_id']) ? $input['quiz_id'] : null;
		// Ensure the quiz exists
		$quiz = null;
		if ($quizId)
		{
			$quiz = Quiz::find($quizId);
		}
		if (! $quiz)
		{
			return ['error', Lang::get('controllers.quiz.quiz_error', ['quiz_id' => $quizId]), 404];
		}
		else if ( ($quiz->user_id != $user->id) && ! $user->is_admin )
		{
			return ['error', Lang::get('controllers.quiz.quiz_no-auth', ['quiz_id' => $quizId]), 401];
		}
		
		// Ensure that there is a user
		if (! $user)
		{
			return ['error', Lang::get('controllers.quiz.quiz_no-auth', ['quiz_id' => $quizId]), 401];
		}
		
		// Ensure that the Question exists, else return a 404.
		$videoquestion = null;
		$videoquestionId = isset($input['videoquestion_id']) ? $input['videoquestion_id'] : null;
		if ($videoquestionId)
		{
			$videoquestion = VideoQuestion::find($videoquestionId);
		}
		if (! $videoquestion)
		{
			return [
				'error',
				Lang::get('controllers.question.question_error', ['question_id' => $videoquestionId]),
				404
			];
		}

		// Ensure the selected definition exists, otherwise return a 400.
		$selectedId = isset($input['selected_id']) ? $input['selected_id'] : null;
		if (! $selectedId)
		{
			return [
				'error',
				Lang::get('controllers.question.answer_invalid', ['selected_id' => $selectedId]),
				400
			];
		}
		
		return parent::response($user, $input);
	}

}
