<?php namespace LangLeap\QuizUtilities;

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\Accounts\User;
use LangLeap\Core\UserInputResponse;

/**
 * Factory that creates quizzes based on selected words in a script
 *
 * @author Quang Tran <tran.quang@live.com>
 */
 class QuizFactory implements UserInputResponse {
 
	private static $instance;
	
	public static function getInstance()
	{
		if(QuizFactory::$instance == null)
		{
			QuizFactory::$instance = new QuizFactory();
		}
		return QuizFactory::$instance;
	}
	
	public function response($user_id, $input)
	{
		if (! $input['all_words'] || count($input['all_words']) < 1)
		{
			return null;
		}
		
		// Retrieve a collection of all definitions in the script.
		$scriptDefinitions = Definition::whereIn('id', $input['all_words'])->get();

		// Use the overriden Collection class.
		$scriptDefinitions = new Collection($scriptDefinitions->all());
		
		$quiz = $this->getDefinitionQuiz($user_id, $input['video_id'], $scriptDefinitions, $input['selected_words']);
		return [
			'success',
			$quiz->toResponseArray(),
			200
		];
	}
	
	/**
	* This function will generate a new Quiz instance based on the supplied
	* collection of Definition instances associated with the script, and an array
	* of Definition IDs that have been chosen by the user to be in the quiz.
	* 
	* @param int $user_id
	* @param  int  $video_id
	* @param  Collection  $scriptDefinitions
	* @param  array $selectedDefinitions
	* @return Quiz
	*/
	public function getDefinitionQuiz($user_id, $video_id, Collection $scriptDefinitions, $selectedDefinitions)
	{
		// Ensure that $scriptDefinitions is not empty.
		if ($scriptDefinitions->isEmpty()) return null;

		// Ensure that $selectedDefinitions is not empty.
		if (count($selectedDefinitions) < 1) return null;
	
		// Ensure the video exists
		if(Video::find($video_id) == null) return null;
		
		// Ensure the user exists
		if(User::find($user_id) == null) return null;
		
		// Create a new quiz
		$quiz = Quiz::create([]);
	
		// Make a copy of the definitions collection.
		$scriptDefinitions = new Collection($scriptDefinitions->all());
		$questionPrepend = 'What is the definition of ';
		
		// Check for questions for each selected definition
		foreach ($selectedDefinitions as $definitionId)
		{
			// Pull the Definition instance from the collection.
			$definition = $scriptDefinitions->pull($definitionId);
			if (! $definition) return null;
				
			$videoQuestion = null;	
			$videoQuestions = VideoQuestion::join('questions', 'questions.id', '=', 'videoquestions.question_id') // Try to find the video question for that word for re-use
				->where('questions.question', 'like', '%' . $definition->word . '%');
			
			foreach($videoQuestions as $vq)
			{
				$indexOfWord = stripos($vq->question()->question, $definition->word);
				if($indexOfWord !== false && $indexOfWord > strlen($questionPrepend) - 1) // Check index in case word appears in question (e.g.: "what")
				{
					$videoQuestion = $vq;
				}
			}
			
			if(!$videoQuestion) // Create a video question if none exists
			{
				$question = $this->createQuestion($questionPrepend, $definition, 4);
				$videoQuestion = VideoQuestion::create([
					'question_id' 	=> $question->id,
					'video_id'		=> $video_id,
					'is_custom'		=> false
				]);
				$quiz->videoQuestions()->attach($videoQuestion->id);
				$videoQuestion->save();
			}
			
			// Create a new result
			$result = Result::create([
				'videoquestion_id' 	=> $videoQuestion->id,
				'user_id'			=> $user_id,
				'is_correct'		=> false
			]);
			$result->save();
		}
		
		// Attach all of the custom questions to the quiz
		$videoQuestions = VideoQuestion::where('video_id', '=', $video_id)->where('is_custom', '=', true)->get();
		foreach($videoQuestions as $vq)
		{
			// Create a new result
			$result = Result::create([
				'videoquestion_id' 	=> $vq->id,
				'user_id'			=> $user_id,
				'is_correct'		=> false
			]);
			$quiz->attach($vq);
		}
		
		$quiz->save();
		return $quiz;
	}
	
	/**
	* Creates a new question with a set amount of answers
	*
	* @param string $questionPrepend
	* @param Definition $definition
	* @param int $numAnswers
	* @return Question
	*/
	protected function createQuestion($questionPrepend, $definition, $numAnswers)
	{
		// Create a new Question instance
		$question = Question::create([
			'answer_id' => -1, // Will be changed after the answer is generated
			'question'	=> $questionPrepend.$definition->word.'?',
		]);
		
		$correctAnswer = Answer::create([
			'question_id' 	=> $question->id,
			'answer'		=> $definition->full_definition
		]);
		$correctAnswer->save();

		$question->answer_id = $correctAnswer->id;
		$question->save();
		
		// Take some close definitions to put as answers
		$other_defs = Definition::where('id', '<', $definition->id)->orderBy('id', 'desc')->take(5)->get();
		$other_defs = $other_defs->merge(Definition::where('id', '>', $definition->id)->orderBy('id', 'asc')->take(5)->get());
		$other_defs = new Collection($other_defs->all());
		
		// Give the question four answers
		while($question->answers->count() < $numAnswers)
		{
			$answer = Answer::create([
				'question_id' 	=> $question->id,
				'answer'			=> $other_defs->pullRandom()->full_definition
			]);
			
			$answer->save();
			$question->answers->add($answer);
		}
		
		return $question;
	}
 }