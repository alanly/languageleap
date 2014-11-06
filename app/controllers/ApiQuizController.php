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

		//Check if there is a quiz associated to this video and user id
		//TODO: NEED TO CHECK USER ID (before authentication was done)
		$quiz = Quiz::where("video_id",$video_id);

		if(! $quiz){
			//Create quiz instance
			$quiz = new Quiz;
			$quiz->user_id = 1;
			$quiz->video_id = $video_id;
			$quiz->save();
		}


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

		//TODO: if there is not enough questions make some from the all_words array

		$jsonResponse = $this->generateJsonResponse($quiz, $questions[0], $definitions);

		return $this->apiResponse(
			'success',
			$jsonResponse
		);
	}


	public function update($id)
	{
		$question = Question::find($id);

		if (! $question)
		{
			return $this->apiResponse(
				'error',
				"question {$id} not found.",
				404
			);
		}

		$selected_id = Input::get("selected_id");

		if(! $selected_id)
		{
			return $this->apiResponse(
				'error',
				"Selected id: {$id} is invalid",
				400
			);
		}

		$question->selected_id = $selected_id;
		$question->save();

		//get the quiz
		$quiz = $question->quiz()->first();

		if( $selected_id == $question->definition_id)
		{
			//Increase the score because they selected the correct definition
			$quiz->increment("score");
		}
		
		$newQuestion = $quiz->questions()->where("selected_id", null)->first();

		if( $newQuestion)
		{
			return $this->apiResponse(
				'success',
				array("Score" => $quiz->score),
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
	*/
	protected function generateJsonResponse(Quiz $quiz, Question $question, $definitions)
	{
		return array(
			"quiz" => $quiz->id,
			"question" => $question->question,
			"question_id" => $question->id,
			"definitions" => $this->definitionResponse($definitions),
		);
	}

	/**
	*	This function will return an array of all the "definition" attributes of all the defintions.
	*/
	protected function definitionResponse($definitions){
		$jsonDefinition = array();

		foreach($definitions as $def)
			array_push($jsonDefinition, $def->definition);

		return $jsonDefinition;
	}
}

