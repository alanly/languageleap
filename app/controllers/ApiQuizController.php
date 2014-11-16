<?php

use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
use LangLeap\Words\Definition;
use LangLeap\QuizUtilities\QuizGeneration;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 */
class ApiQuizController extends \BaseController {

	/**
	 * This function will generate a json response that will contain, the quiz (new or old depending if there has been a quiz for this video and user), a question and its ID
	 * as well as all the possible answers for the question.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Make sure video id is real.
		$videoId = Input::get("video_id");

		if (! $videoId)
		{
			return $this->apiResponse(
				'error',
				"Video id {$videoId} does not exists",
				404
			);
		}

		//All the selected words. This list can be empty.
		$selectedWords = Input::get("selected_words");

		//All the words in the script
		$scriptWords = Input::get("all_words");

		//if all words is empty or null return 404 
		if (! $scriptWords)
		{
			return $this->apiResponse(
				'error',
				"No Definitions available",
				404
			);
		}
		
		//create the array of deinitions to be used for the quiz
		$definitions = array();

		//verification of Input Arrays.
		foreach ($scriptWords as $definitionId) 
		{
			$definition = Definition::find($definitionId);

			//if Definition does not exist return 404 error
			if(! $definition){
				return $this->apiResponse(
					'error',
					"Definition {$definitionId} does not exists",
					404
				);
			}
			//Add the definition to the list.
			$definitions[$definition->id] = $definition;
		}		

		if ($selectedWords)
		{
			foreach ($selectedWords as $definitionId) 
			{
				//if the definition is not in list created from all words return 404
				//This should never happen unless some tamporing has been done.
				if(! in_array($definitionId, $scriptWords)){
					return $this->apiResponse(
						'error',
						"Selected Definition {$definitionId} does not exists",
						404
					);
				}
			}

			$quiz = QuizGeneration::generateQuiz($definitions, $selectedWords);

			//Setting the video id
			$quiz->video_id = $videoId;
			$quiz->save();

			$question = $quiz->questions()->where("selected_id", null)->first();

			$jsonResponse = $this->generateJsonResponse($quiz, $question, $definitions);

			return $this->apiResponse(
				'success',
				$jsonResponse
			);
		}
		else
		{
			//Get URL to next video
			//OR return to home page

			return $this->apiResponse(
				'success',
				array("nextStep" => "http://www.google.ca"),
				200
			);
		}	
	}

	/**
	*	This function will be used to answer a question. It will increase the users quiz score if he selected the proper answer.
	*
	*/
	public function update($id)
	{
		$question = Question::find($id);

		if (! $question)
		{
			return $this->apiResponse(
				'error',
				"Question {$id} not found.",
				404
			);
		}

		$selected_id = Input::get("selected_id");

		if (! $selected_id)
		{
			return $this->apiResponse(
				'error',
				"Selected id: {$id} is invalid",
				400
			);
		}

		//Save the users answer in the question.
		$question->selected_id = $selected_id;
		$question->save();

		//get the quiz
		$quiz = $question->quiz()->first();

		if ( $selected_id == $question->definition_id)
		{
			//Increase the score because they selected the correct definition
			$quiz->increment("score");
		}
		else
		{
			//TODO: Add to user progress when we do authentication 
		}
		
		$newQuestion = $quiz->questions()->where("selected_id", null)->first();
		$numberOfQuestions = $quiz->questions()->count();

		if (! $newQuestion)
		{
			//TODO: get next video here
			return $this->apiResponse(
				'success',
				array("Score" => $quiz->score . " / " . $numberOfQuestions),
				200
			);	
		}
		
		return $this->apiResponse(
			'success',
			$newQuestion->toArray(),
			200
		);	
	}

	/**
	*	This function will generate the valid json response for a valid quiz
	*
	*	@param Quiz The quiz that was created
	*	@param Question The question in the quiz
	*	@param Definition[] All the definitions for this particular Quiz
	*	
	* 	@return Associative Array for the JSON response.
	*
	*/
	protected function generateJsonResponse(Quiz $quiz, Question $question, $definitions)
	{
		return array(
			"quiz" => $quiz->id,
			"question" => $question->question,
			"question_id" => $question->id,
			"definitions" => QuizGeneration::generateQuestionDefinitions($definitions, $question->definition_id),
		);
	}

}
