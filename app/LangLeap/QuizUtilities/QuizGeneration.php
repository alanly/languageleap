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
		$question = new Question;

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

			$answer = Answer::create([
				'answer' 		=> $definition->full_definition,
				'question_id'	=> $question->id,
			]);

			$question->answer_id = $answer->id;
		}

		$question->save();
		return $question;
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
	public static function generateQuestionDefinitions($scriptDefinitions, $answerId)
	{
		$scriptDefinitions = new Collection($scriptDefinitions->all());
		$answers = new Collection;

		// Throw in the correct answer, since we already know it.
		$answer = $scriptDefinitions->pull($answerId);

		if (! $answer) return null;
		
		$answers->push($answer);

		// Pad out our selection of answers (up to 4) with random definitions.
		while ($answers->count() < 4 && ! $scriptDefinitions->isEmpty())
		{
			$answers->push($scriptDefinitions->pullRandom());
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
	protected static function formatDefinitionForResponse(Definition $definition)
	{
		return [
			'id' => $definition->id,
			'description' => $definition->full_definition,
		];
	}
}

