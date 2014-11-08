<?php

use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Question;
use LangLeap\Words\Definition;

/**
*	@author Thomas Rahn <thomas@rahn.ca>
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
		$quiz = Quiz::where("video_id",$video_id)->first();

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

		//if all words is empty or null return 404 
		if(! $all_words)
		{
			return $this->apiResponse(
				'error',
				"No Definitions available",
				404
			);
		}
		
		//create the array of deinitions to be used for the quiz
		$definitions = array();


		foreach ($all_words as $definitionId) 
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

		$questions = array();

		if( $selected_words){
			foreach ($selected_words as $definitionId) 
			{
				//if the definition is not in list created from all words return 404
				//This should never happen unless some tamporing has been done.
				if(! in_array($definitionId, $all_words)){
					return $this->apiResponse(
						'error',
						"Selected Definition {$definitionId} does not exists",
						404
					);
				}

				$definition = $definitions[$definitionId];

				//Create the question
				$question = new Question;
				$question->quiz_id = $quiz->id;
				$question->definition_id = $definitionId;
				$question->question = "What is the definition for " . $definition->word;
				$question->save();
				array_push($questions, $question);
			}
		}		
		
		//TODO: if there is not enough questions make some from the all_words array
		$jsonResponse = $this->generateJsonResponse($quiz, $questions[0], $definitions);

		return $this->apiResponse(
			'success',
			$jsonResponse
		);
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
		}else
		{
			//TODO: Add to user progress when we do authentication 
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
			"definitions" => $this->definitionResponse($definitions, $question->definition_id),
		);
	}

	/**
	*	This function will return an array of all the "definition" attributes of all the defintions.
	*
	*	This is the function that will generate the possible answers for the question, it will also shuffle them so the answer isn't always on top.
	*/
	protected function definitionResponse($definitions, $answerId){
		$jsonDefinition = array();

		//add the answer
		array_push($jsonDefinition, $definitions[$answerId]->definition);

		if(count($definitions)<= 4)
		{
			foreach($definitions as $def)
			{
				array_push($jsonDefinition, $def->definition);
			}
		}else{
			$definitionKeys = array_keys($definitions);

			while(count($jsonDefinition) < 4){
				//generate random number from 0 to number of definitions.
				$ran = rand(0,count($definitions)-1);

				$defId = $definitionKeys[$ran];

				//if it is not in the list add it, otherwise the loop with execute again.
				if(!in_array($definitions[$defId]->definition, $jsonDefinition)){
					array_push(	$jsonDefinition, $definitions[$defId]->definition);
				}
			}
		}

		//shuffle the array to change the position of the answer
		shuffle($jsonDefinition);
		return $jsonDefinition;
	}
}

