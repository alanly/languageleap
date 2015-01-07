<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\UserInputResponse;
use LangLeap\Core\InputDecorator;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;

/**
 * Concrete decorator that adds validation behavior to Quiz creation
 *
 * @author Quang Tran <tran.quang@live.com>
 */
class QuizAnswerValidation extends InputDecorator
{
	function __construct(UserInputResponse $decoratedInputResponse)
	{
		parent::__construct($decoratedInputResponse);
	}
	
	public function response($user_id, $input)
	{
		// Ensure that the Question exists, else return a 404.
		$videoquestion = null;
		if(isset($input['videoquestion_id']))
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
		if(isset($input['quiz_id']))
		{
			$quiz_id = $input['quiz_id'];
			$quiz = Quiz::find($quiz_id);
		}
		if(!$quiz)
		{
			return [
				'error',
				"Quiz {$quiz_id} not found.",
				404
			];
		}
		
		return parent::response($user_id, $input);
	}
}