<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;


/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class QuizGeneration {

	/**
	* This function will generate a new Quiz instance based on the supplied
	* collection of Definition instances associated with the script, and an array
	* of Definition IDs that have been chosen by the user to be in the quiz.
	* 
	* Generated quizzes do not contain the association with a video.
	* 
	* @param  Collection  $scriptDefinitions
	* @param  array       $selectedDefinitions
	* @return VideoQuestion array
	*/
	public static function generateDefinitionQuiz(Collection $scriptDefinitions, $selectedDefinitions)
	{
		// Ensure that $scriptDefinitions is not empty.
		if ($scriptDefinitions->isEmpty()) return null;

		// Ensure that $selectedDefinitions is not empty.
		if (count($selectedDefinitions) < 1) return null;

		// Make a copy of the definitions collection.
		$scriptDefinitions = new Collection($scriptDefinitions->all());

		$questions = array();

		// Generate the Question and Answer instances for each question.
		foreach ($selectedDefinitions as $definitionId)
		{
			// Pull the Definition instance from the collection.
			$definition = $scriptDefinitions->pull($definitionId);

			if (! $definition) return null;

			// Create a new Question instance
			$question = Question::create([
				'answer_id' => -1, // Will be changed after the answer is generated
				'question'	=> 'What is the definition of '.$definition->word.'?',
			]);

			$correctAnswer = Answer::create([
				'question_id' 	=> $question->id,
				'answer'		=> $definition->full_definition
				]);
			$correctAnswer->save();

			$question->answer_id = $correctAnswer->id;
			$question->save();

			array_push($questions, $question);
		}

		
		return $questions;
	}


	/**
	 * Generates an appropriately formatted array of possible answer-definitions
	 * based upon the available script definition instances and the definition ID
	 * of the answer.
	 * 
	 * Results are shuffled so they appear randomized.
	 * 
	 * @param  Collection  $scriptDefinitions
	 * @param  int         $answerId
	 * @return array
	 */
	public static function generateAnswers($scriptDefinitions, $question)
	{
		$scriptDefinitions = new Collection($scriptDefinitions->all());
		$answers = new Collection;

		// Throw in the correct answer, since we already know it.
		$answer = Answer::find($question->answer_id)->first();
		$scriptDefinitions->pull($question->answer_id);

		if (! $answer)
		{
			return $this->apiResponse(
				'error',
				"No answer found for {$question->question}.",
				400
			);
		}
		
		$answers->push($answer);

		// Pad out our selection of answers (up to 4) with random definitions.
		while ($answers->count() < 4 && ! $scriptDefinitions->isEmpty())
		{
			$randomAnswer = $scriptDefinitions->pullRandom();
			$a = Answer::create([
				'answer' 		=> $randomAnswer->full_definition,
				'question_id'	=> $question->id,
			]);
			$a->save();

			$answers->push($a);
		}

		// Shuffle/randomize the answers.
		$answers->shuffle();

		// Transform the answers into the appropriate format for the API.
		$answers->transform(function($item) 
		{
			return self::formatDefinitionForResponse($item);
		});

		return $answers->all();
	}


	/**
	 * Formats a given Definition instance into an appropriate array
	 * representation for the JSON API.
	 * 
	 * @param  Definition  $definition
	 * @return array
	 */
	protected static function formatDefinitionForResponse(Answer $answer)
	{
		return [
			'id' => $answer->id,
			'answer' => $answer->answer,
		];
	}
}

