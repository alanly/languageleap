<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;

/**
 * Factory that creates quizzes based on selected words in a script
 *
 * @author Quang Tran <tran.quang@live.com>
 */
 class QuizFactory {
 
	private static $instance;
	
	public static function getInstance()
	{
		if(QuizFactory::$instance == null)
		{
			QuizFactory::$instance = new QuizFactory();
		}
		return QuizFactory::$instance;
	}
	
	/**
	* This function will generate a new Quiz instance based on the supplied
	* collection of Definition instances associated with the script, and an array
	* of Definition IDs that have been chosen by the user to be in the quiz.
	* 
	* Generated quizzes do not contain the association with a video.
	* 
	* @param  int  $video_id
	* @param  Collection  $scriptDefinitions
	* @param  array       $selectedDefinitions
	* @return VideoQuestion array
	*/
	public function getDefinitionQuiz(Collection $scriptDefinitions, $selectedDefinitions)
	{
		// Ensure that $scriptDefinitions is not empty.
		if ($scriptDefinitions->isEmpty()) return null;

		// Ensure that $selectedDefinitions is not empty.
		if (count($selectedDefinitions) < 1) return null;
	
		$quiz = new Quiz;
	
		// Make a copy of the definitions collection.
		$scriptDefinitions = new Collection($scriptDefinitions->all());
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
			
			//$quiz->videoQuestions->add($question);
		}
		
		return $quiz;
	}
	
	public function getCustomQuiz()
	{
		throw new \Exception("Not implemented");
	}
 }