<?php


use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
use LangLeap\Words\Definition;

/**
*	@author Thomas Rahn <thomas@rahn.ca>
*/
class ApiQuizController extends \BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$video_id = Input::get("video_id");

		if (! $video_id)
		{
			return $this->apiResponse(
				'error',
				"Video id {$video_id} does not exists",
				404
			);
		}

		//Create quiz instance
		$quiz = new Quiz;
		$quiz->user_id = 1;
		$quiz->video_id = $video_id;
		$quiz->save();

		//All the selected words. This list can be empty.
		$selected_words = Input::get("selected_words");

		//All the words in the script
		$all_words = Input::get("all_words");

		if(! $all_words && ! $selected_words)
		{
			return $this->apiResponse(
				'error',
				"No Definitions available",
				404
			);
		}
		
		$definitions = array();

		foreach ($all_words as $definition_id) 
		{
			$definition = Definition::find($definition_id);
			//if Definition does not exist return 404 error

			if(! $definition){
				return $this->apiResponse(
					'error',
					"Definition {$definition_id} does not exists",
					404
				);
			}

			$definitions[$definition->id] = $definition;
		}		

		$questions = array();

		foreach ($selected_words as $definition_id) 
		{
			//Get the definition
			$definition = $definitions[$definition_id];

			if(! $definition){
				return $this->apiResponse(
					'error',
					"Selected Definition {$definition_id} does not exists",
					404
				);
			}


			//Create the question
			$question = new Question;
			$question->quiz_id = $quiz->id;
			$question->definition_id = $definition_id;
			$question->question = "What is the definition for " . $definition->word;
			$question->save();
			array_push($questions, $question);
		}

		$jsonResponse = $this->generateJsonResponse($quiz, $questions[0], $definitions);

		return $this->apiResponse(
			'success',
			$jsonResponse
		);
	}

	/**
	*	This function will generate the valid json response for a valid quiz
	*
	*/
	protected function generateJsonResponse(Quiz $quiz, Question $question, $definitions)
	{

		return array(
			"quiz" => $quiz->id,
			"question" => $question->toArray(),
			"definitions" => $definitions,
		);
	}
}

