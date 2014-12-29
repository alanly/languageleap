<?php

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\Quiz;
use LangLeap\QuizUtilities\QuizFactory;
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
		// Ensure the video exists.
		$videoId = Input::get("video_id");
		if (Video::find($videoId) == null)
		{
			return $this->apiResponse(
				'error',
				"Video {$videoId} does not exists",
				404
			);
		}

		// Get all the selected words; if empty, return with redirect.
		$selectedWords = Input::get("selected_words");
		if (! $selectedWords || count($selectedWords) < 1)
		{
			return $this->apiResponse(
				'success',
				[ 'result' => ['redirect' => 'http://www.google.ca/'] ]
			);
		}

		// Get all the words in the script; if empty, return 400 (client-side error).
		$scriptWords = Input::get("all_words");
		if (! $scriptWords || count($scriptWords) < 1)
		{
			return $this->apiResponse(
				'error',
				"Empty script supplied for video {$videoId}.",
				400
			);
		}

		// Retrieve a collection of all definitions in the script.
		$scriptDefinitions = Definition::whereIn('id', $scriptWords)->get();

		// Use the overriden Collection class.
		$scriptDefinitions = new Collection($scriptDefinitions->all());

		// Store the script definitions in the session for future requests.
		Session::put('scriptDefinitions', $scriptDefinitions);

		// If words are missing, then return a 404.
		if ($scriptDefinitions->count() != count($scriptWords))
		{
			return $this->apiResponse(
				'error',
				'Only '.$scriptDefinitions->count().' definitions found for '.count($scriptWords).' words.',
				404
			);
		}

		// Ensure that the _selected_ words are within the realm of the script.
		foreach ($selectedWords as $definitionId)
		{
			// If a selected word is not in the script, return 404.
			if (! $scriptDefinitions->contains($definitionId))
			{
				return $this->apiResponse(
					'error',
					"Selected definition {$definitionId} is not in video {$videoId}.",
					404
				);
			}
		}

		// Generate all the questions.
		$quiz = QuizFactory::getInstance()->getDefinitionQuiz(Auth::user()->id, $videoId, $scriptDefinitions, $selectedWords);
		return $this->apiResponse(
			'success',
			$quiz->toResponseArray()
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
