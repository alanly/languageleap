<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

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
	public function getDefinitionQuiz($video_id, Collection $scriptDefinitions, $selectedDefinitions)
	{
		// Ensure that $scriptDefinitions is not empty.
		if ($scriptDefinitions->isEmpty()) return null;

		// Ensure that $selectedDefinitions is not empty.
		if (count($selectedDefinitions) < 1) return null;
	
		// Ensure the video exists
		if(Video::find($video_id) == null) return null;
		
		$quiz = Quiz::create([]);
		$quiz->save();
	
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
			
			// Take some close definitions to put as answers
			$other_defs = Definition::where('id', '<', $definitionId)->orderBy('desc')->take(5)->get();
			$other_defs->merge(Definition::where('id', '>', $definitionId)->orderBy('asc')->take(5)->get());
			$other_defs = new Collection($other_defs->all());
			
			// Give the question four answers
			while($question->answers->count() < 4)
			{
				$answer = Answer::create([
					'question_id' 	=> $question->id,
					'answer'			=> $other_defs->pullRandom()->full_definition
				]);
				
				$answer->save();
				$question->answers->add($answer);
			}
			
			$videoQuestion = VideoQuestion::create([
				'video_id' 		=> $video_id,
				'question_id' 	=> $question->id,
				'quiz_id'			=> $quiz->id,
				'is_custom'	=> false
			]);
			$videoQuestion->save();
		}
		
		return $quiz;
	}
	
	public function getCustomQuiz()
	{
		throw new \Exception("Not implemented");
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