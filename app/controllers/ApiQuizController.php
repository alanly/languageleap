<?php

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\QuizUtilities\QuizGeneration;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class ApiQuizController extends \BaseController {

	protected $questions;
	protected $answers;
	protected $videos;

	public function __construct(Question $question, Answer $answers, Video $video)
	{
		$this->questions = $question;
		$this->answers = $answers;
		$this->videos = $video;
	}

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

		if ($this->videos->where('id', $videoId)->count() < 1)
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
		$question = QuizGeneration::generateDefinitionQuiz($scriptDefinitions, $selectedWords);
		$vq = VideoQuestion::create([
				'question_id' 	=> $question->id,
				'video_id'		=> $videoId,
				'is_custom'		=> false
			]);
		$vq->save();


		return $this->apiResponse(
			'success',
			$this->generateJsonResponse($vq, null, $question, $scriptDefinitions)
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
		$questionId = Input::get('question_id');
		$question = Question::find($questionId);

		if (! $question)
		{
			return $this->apiResponse(
				'error',
				"Question {$questionId} not found.",
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

		// Save the users answer in the question.
		$question->selected_id = $selectedId;
		$question->save();

		// Retrieve the associated Quiz instance.
		$quiz = $question->quiz()->first();

		// Update the score if the user answered correctly.
		if ($selectedId == $question->definition_id.'')
		{
			// Increment the score because they selected the right answer.
			$quiz->increment("score");

			// @TODO: Adjust user progress
		}
		
		// Get an unanswered question.
		$newQuestion = $quiz->questions()->unanswered()->first();

		// If there are no more questions left, return the result.
		if (! $newQuestion)
		{
			// Get the counts.
			$numberOfTotalQuestions = $quiz->questions()->count();
			$numberOfCorrectAnswers = $quiz->score;

			// Generate the response.
			$response = $this->generateJsonResponse($quiz, $question, null, null);
			$response['result'] = [
				'score'    => ((float)$numberOfCorrectAnswers / $numberOfTotalQuestions) * 100,
				'redirect' => 'https://www.google.ca/', // @TODO: Determine the next video.
			];

			// Forget the definitions.
			Session::forget('scriptDefinitions');

			return $this->apiResponse('success', $response);
		}

		// Ensure we still have our script definitions that we stored from the
		// original GET request.
		if (! Session::has('scriptDefinitions'))
		{
			return $this->apiResponse(
				'error',
				'Unable to retrieve the stored definitions. Please contact an administrator.',
				500
			);
		}
		
		return $this->apiResponse(
			'success',
			$this->generateJsonResponse($quiz, $question, $newQuestion, Session::get('scriptDefinitions'))
		);
	}

	/**
	 * Generates an appropriately formed data-array for the JSON response.
  	 *
  	 * @param  Quiz             $quiz
  	 * @param  Question|null    $previousQuestion
  	 * @param  Question|null    $currentQuestion
  	 * @param  Collection|null  $definitions
  	 * @return array
  	 */
	protected function generateJsonResponse(VideoQuestion $vq, $previousQuestion, $currentQuestion, $definitions)
	{
		$response = [];

		$response['videoquestion_id'] = $vq->id;

		if ($previousQuestion !== null)
		{
			$response['previous'] = [
				'selected' => $previousQuestion->selected_id,
				'answer'   => $previousQuestion->answer_id,
				'result'   => $previousQuestion->selected_id === $previousQuestion->answer_id.'',
			];
		}

		if ($currentQuestion !== null)
		{
			$isLast = $vq->count() == 1;

			$response['question'] = [
				'id' => $currentQuestion->id,
				'question' => $currentQuestion->question,
				'answer_id' => $currentQuestion->answer_id, 
				'answers' => QuizGeneration::generateQuestionDefinitions($definitions, $currentQuestion),
			];
		}

		return $response;
	}

}
