<?php

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\Quiz;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\QuizUtilities\QuizInputValidation;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class ApiQuizController extends \BaseController {

	/**
	 * This function will generate a json response that will contain, the quiz 
	 * (new or old depending if there has been a quiz for this video and user), 
	 * a question and its ID as well as all the possible answers for the
	 * question.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		$quizDecorator = new QuizInputValidation(QuizFactory::getInstance());

		// Generate all the questions.
		$response = $quizDecorator->response(Auth::user()->id, Input::all());
		return $this->apiResponse(
			$response[0],
			$response[1],
			$response[2]
		);
	}

	/**
	 * This function will be used to answer a question. It will increase the
	 * users quiz score if he selected the proper answer.
	 * 
	 * @return Response
	 */
	public function putIndex()
	{
		// Ensure that the Question exists, else return a 404.
		$videoquestion_id = Input::get('videoquestion_id');
		$videoquestion = VideoQuestion::find($videoquestion_id);
		if (! $videoquestion)
		{
			return $this->apiResponse(
				'error',
				"Question {$videoquestion_id} not found.",
				404
			);
		}

		// Ensure the selected definition exists, otherwise return a 404.
		$selectedId = Input::get("selected_id");
		if (! $selectedId)
		{
			return $this->apiResponse(
				'error',
				"The selected definition {$selectedId} is invalid",
				400
			);
		}
		
		$result = Result::join('videoquestions', 'results.videoquestion_id', '=', 'videoquestions.id')
			->where('videoquestions.id', '=', $videoquestion_id)
			->where('results.user_id', '=', Auth::user()->id)
			->orderBy('timestamp', 'desc')->first();
		if (! $result)
		{
			return $this->apiResponse(
				'error',
				"No result for user for question {$videoquestion_id}",
				400
			);
		}

		$isCorrectAnswer = $videoquestion->question->answer_id.'' === $selectedId;

		if($isCorrectAnswer)
		{
			$result->is_correct = true;
			$result->save();
		}

		return $this->apiResponse(
			'success',
			[
				'is_correct'	=> $isCorrectAnswer
			]
		);
	}
}
