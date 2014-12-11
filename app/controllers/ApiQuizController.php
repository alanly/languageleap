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

		$resultId = Input::get('result_id');
		$result = Result::find($resultId);

		if (! $result)
		{
			return $this->apiResponse(
				'error',
				"The Result id {$resultId} is invalid",
				400
			);
		}

		$videoQuestion = VideoQuestion::find($result->videoquestion_id);

		if (! $videoQuestion)
		{
			return $this->apiResponse(
				'error',
				"The VideoQuestion object with id {$videoQuestionId} is invalid",
				400
			);
		}

		$isCorrectAnswer = $question->answer_id.'' === $selectedId;

		// Update the score if the user answered correctly.
		/*if ($isCorrectAnswer)
		{
			// Increment the score because they selected the right answer.
			$result->is_correct = $isCorrectAnswer;
			// @TODO: Adjust user progress
		}
		$result->increment('attempt');
		$result->save();*/
		
		// Get an unanswered question.
		$newQuestionResult = $this->getUnansweredQuestionResult($videoQuestion->video_id);
		$newQuestion = $this->getUnansweredQuestion($newQuestionResult);

		// If there are no more questions left, return the result.
		if (! $newQuestion)
		{
			// Get the counts.
			$numberOfTotalQuestions = 1; //@TODO
			$numberOfCorrectAnswers = 1; //@TODO

			// Generate the response.
			$response = $this->generateJsonResponse($result, $question, null, null);
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
			$this->generateJsonResponse($newQuestionResult, $question, $newQuestion, Session::get('scriptDefinitions'))
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
	protected function generateJsonResponse($result, $previousQuestion, $currentQuestion, $definitions)
	{
		$response = [];

		$response['result_id'] = $result->id;

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
			$isLast = $this->isLastQuestion($result);

			$response['question'] = [
				'id' 		=> $currentQuestion->id,
				'question' 	=> $currentQuestion->question,
				'answer_id' => $currentQuestion->answer_id, 
				'answers' 	=> QuizGeneration::generateAnswers($definitions, $currentQuestion),
				'last'		=> $isLast
			];
		}

		return $response;
	}

	protected function getUnansweredQuestionsResults($videoId)
	{
		//Get all results of the user that have no attempts (he never tried to answer)
		//Then get all the VideoQuestion instances that are related to the video he is currently\
		$results = new Collection;
		foreach(Quiz::where('user_id', '=', Auth::user()->id) as $quiz)
		{
			$videoQuestions =  $quiz->videoQuestions();
			foreach($videoQuestions as $vq)
			{
				if($vq->video_id == $videoId)
				{
					foreach($vq->results as $result)
					{
						$results->add($result);
					}
				}
			}
		}
		
		return $results;
	}

	protected function getUnansweredQuestionResult($videoId)
	{
		return $this->getUnansweredQuestionsResults($videoId)->first();
	}

	protected function getUnansweredQuestion($result)
	{
		$videoquestionId = $result->videoquestion_id;
		$videoquestion = VideoQuestion::find($videoquestionId);
		$question = Question::find($videoquestion->question_id);

		return $question;
	}

	protected function getNumberOfQuestions($videoId)
	{
		return DB::table('results')
		->join('videoquestion', 'results.videoquestion_id', '=', 'videoquestion.id')
		->select('results.id', 'results.videoquestion_id', 'results.user_id', 'results.id', 'results.attempt')
		->where('user_id', Auth::user()->id.'')
		->count();
	}

	protected function isLastQuestion($result)
	{
		$videoquestionId = $result->videoquestion_id;
		$videoquestion = VideoQuestion::find($videoquestionId);
		return ($this->getUnansweredQuestionsResults($videoquestion->video_id)->count() === 1);
	}

}
