<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\Collection;
use LangLeap\Core\UserInputResponse;
use LangLeap\Quizzes\Answer;
use LangLeap\QuestionUtilities\QuestionFactory;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\WordUtilities\WordInformation;
use LangLeap\Words\Script;

/**
 * Factory that creates quizzes based on selected words in a script
 *
 * @author Quang Tran 	<tran.quang@live.com>
 * @author Dror Ozgaon 	<dror.ozgaon@gmail.com>
 */
class QuizFactory implements UserInputResponse {
 
	private static $instance;
	
	public static function getInstance()
	{
		if (QuizFactory::$instance == null)
		{
			QuizFactory::$instance = new QuizFactory();
		}

		return QuizFactory::$instance;
	}
	
	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  User  $user
	 * @param  array $input
	 * @return array
	 */
	public function response(User $user, array $input)
	{
		if($input) // there is input then create a quiz based on that
		{
			if (! $input['all_words'] || count($input['all_words']) < 1)
			{
				return null;
			}

			// Ensure the video exists
			$videoId = $input['video_id'];
			if (Video::find($videoId) == null) return null;
			
			// Retrieve the word, its associated definition, and the sentence it is in.
			$allWords = $input['all_words'];
			$wordsInformation = array();

			for($i = 0; $i < count($allWords); $i++)
			{
				// Ensure word exists.
				$word = $allWords[$i]['word'];
				if(!$word) return null;

				// Ensure sentence the word is in exists.
				$sentence = $allWords[$i]['sentence'];
				if(!$sentence) return null;

				// If the definition doesn't exist, the WordInformation class will fetch the definition.
				$wordInformation = new WordInformation($word, $allWords[$i]['definition'], $sentence, $videoId);

				if(strlen($wordInformation->getDefinition()) < 1) return null;

				array_push($wordsInformation, $wordInformation);
			}
			
			$quiz = $this->getDefinitionQuiz(
				$user->id,
				$input['video_id'],
				$wordsInformation
			);

			return ['success', ['quiz_id' => $quiz->id], 200];
		}
		else // Create a quiz from questions that are wrong
		{
			$quiz = $this->getReminderQuiz($user->id);
			if(! $quiz)
			{
				return ['success', ['quiz_id' => -1], 200];
			}
			else
			{
				return ['success', ['quiz_id' => $quiz->id], 200];
			}
		}
	}
	
	/**
	 * This function will generate a new Quiz instance based on the supplied
	 * array of words selected from the script.
	 * 
	 * @param  int         $user_id
	 * @param  int         $video_id
	 * @param  array       $wordsInformation
	 * @return Quiz
	 */
	public function getDefinitionQuiz($user_id, $video_id, $wordsInformation)
	{
		// Ensure that $selectedWords is not empty.
		if (count($wordsInformation) < 1) return null;
		
		// Ensure the user exists
		if (User::find($user_id) == null) return null;
		
		// Ensure the video exists
		if (Video::find($video_id) == null) return null;
		
		// Create a new quiz
		$quiz = Quiz::create(['user_id'	=> $user_id]);
		
		$questionPrepend = 'What is the definition of ';
		
		// Check for questions for each selected definition
		foreach ($wordsInformation as $word)
		{
			// Create a video question if none exists
			$question = $this->createDefinitionQuestion($questionPrepend, $word, 4, $video_id);

			$videoQuestion = VideoQuestion::create([
				'question_id' => $question->id,
				'video_id'		=> $video_id,
				'is_custom'		=> false // TODO Might not be required later on
			]);

			$videoQuestion->save();
			
			// Add an entry to the pivot table
			$quiz->videoQuestions()->attach($videoQuestion->id);
		}
		
		// Attach all of the custom questions to the quiz
		$videoQuestions = VideoQuestion::where('video_id', '=', $video_id)
		                               ->where('is_custom', '=', true)
		                               ->get();

		foreach ($videoQuestions as $vq)
		{
			$quiz->videoQuestions()->attach($vq->id);
		}
		
		$quiz->save();


		return $quiz;
	}
	
	/**
	 *  This function will generate a new Quiz instance based on the questions that
	 *  have been answered incorrectly in the past.
	 * 
	 * @param  int         $user_id
	 */
	public function getReminderQuiz($user_id)
	{
		$allQuestions = VideoQuestion::select(
			array('videoquestions.*', 
			\DB::raw('COUNT(NULLIF(videoquestion_quiz.is_correct, 0)) as correct'), 
			\DB::raw('COUNT(NULLIF(videoquestion_quiz.is_correct, 1)) as incorrect'))
		)
			->join('videoquestion_quiz', 'videoquestion_quiz.videoquestion_id', '=', 'videoquestions.id')->join('quizzes', 'quizzes.id', '=', 'videoquestion_quiz.quiz_id')
			->where('videoquestions.is_custom', '=', false)->where('videoquestion_quiz.attempted', '=', true)
			->where('quizzes.user_id', '=', $user_id)->groupBy('videoquestions.id')->get();
		
		$videoQuestions = new Collection([]);
		foreach($allQuestions as $q) // Possibly add the question to the reminder quiz if it has been wrong more than 34% of the time.
		{
			$percentRight = (float)$q->correct/(float)($q->correct + $q->incorrect);
			if($percentRight < 0.66)
			{
				$videoQuestions->add($q);
			}
		}
		
		if($videoQuestions->count() > 0)
		{
			$quiz = Quiz::create(['user_id' => $user_id]);
			
			while($videoQuestions->count() > 0 && $quiz->videoQuestions()->count() < 5)
			{
				$vq = $videoQuestions->shift();
				$quiz->videoQuestions()->attach($vq->id);
			}
			$quiz->save();
			
			return $quiz;
		}
		
		return null;
	}
	
	/**
	 * Creates a new definition question with a set amount of answers
	 *
	 * @param  string      $questionPrepend
	 * @param  string  	   $definition
	 * @param  int         $numAnswers
	 * @param  int         $videoId
	 * @return Question
	 */
	protected function createDefinitionQuestion($questionPrepend, $wordInformation, $numAnswers, $videoId)
	{
		$question = QuestionFactory::getInstance()->getDefinitionQuestion($questionPrepend, $wordInformation);

		$correctAnswer = Answer::create([
			'question_id' => $question->id,
			'answer'      => $wordInformation->getDefinition()
		]);
		$correctAnswer->save();

		$question->answer_id = $correctAnswer->id;
		$question->save();

		$randomWords = $this->getRandomWords($wordInformation->getWord(), $numAnswers, $videoId);

		foreach($randomWords as $randomWord)
		{
			$answer = Answer::create([
				'question_id' => $question->id,
				'answer'      => $randomWord->getDefinition()
			]);
			$question->answers->add($answer);
		}
		
		return $question;
	}

	/**
	 * Creates an array of random words to put as incorrect answers
	 *
	 * @param  int         $numAnswers
	 * @return array
	 */
	private function getRandomWords($correctWord, $numAnswers, $videoId)
	{
		// Get a random script
		$numberOfScripts = Script::count();
		$randomNumber = rand(1, $numberOfScripts);

		$randomScript = Script::find($randomNumber);
		$wordsInScript = $randomScript->text;

		// Remove all the tags from the script (e.g <span data="speaker">word</span>), replace with a whitespace
		$wordsInScript = trim(preg_replace('/\s*\<[^>]*\>\s*/', ' ', $wordsInScript));

		// Get all words, shuffle them around
		$words = str_word_count($wordsInScript, 1);
		shuffle($words);
		$randomWords = array();

		// Get 3 words with length > 3 which are different than the word in the question
		foreach($words as $word)
		{
			if($correctWord != $word && strlen($word) > 3)
			{
				// Get the definition of the word, if successful push into the array
				$wordInformation = new WordInformation($word, '', '', $videoId);
				if(strlen($wordInformation->getDefinition()) > 1) 
				{
					array_push($randomWords, $wordInformation);
				}
			}

			if(count($randomWords) > $numAnswers - 1) return $randomWords;
		}

	}
}
