<?php namespace LangLeap\QuizUtilities;

use LangLeap\Accounts\User;
use LangLeap\Core\Collection;
use LangLeap\Core\UserInputResponse;
use LangLeap\Quizzes\Answer;
use LangLeap\QuestionUtilities\QuestionFactory;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\ReminderQuiz;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\VideoQuiz;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;
use LangLeap\WordUtilities\WordInformation;
use LangLeap\Words\Script;
use Lang;

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
			$quiz = $this->getVideoQuiz($user->id, $input['video_id'], $input['selected_words']);
			
			return ['success', 
			[
				'quiz_id' => $quiz->id,
				'redirect' => $this->getNextVideoPath($input['video_id'])
			],
			200];
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
	 * @param  array     $selectedWords
	 * @return Quiz
	 */
	public function getVideoQuiz($user_id, $video_id, $selectedWords)
	{
		// Retrieve the word, its associated definition, and the sentence it is in.
		$wordsInformation = WordInformation::fromInput($selectedWords, $video_id);
		
		$category = VideoQuiz::create([ 'video_id' => $video_id ]);
		
		// Create a new quiz
		$quiz = Quiz::create([
			'user_id'			=> $user_id,
			'category_id'		=> $category->id,
			'category_type'	=> 'LangLeap\Quizzes\VideoQuiz',
		]);
		
		$questionPrepend = Lang::get('quiz.definition_of');
		
		// Check for questions for each selected definition
		foreach ($wordsInformation as $word)
		{
			// Create a video definition question if none exists
			$definitionQuestion = $this->createDefinitionQuestion($questionPrepend, $word, 4, $video_id);

			// Create a video drag and drop question if none exists
			$dragAndDropQuestion = $this->createDragAndDropQuestion($word, 4, $video_id);

			$videoQuestionDefinition = VideoQuestion::create([
				'question_id' => $definitionQuestion->id,
				'video_id'		=> $video_id,
				'is_custom'		=> false // TODO Might not be required later on
			]);

			$videoQuestionDragAndDrop = VideoQuestion::create([
				'question_id' => $dragAndDropQuestion->id,
				'video_id'		=> $video_id,
				'is_custom'		=> false // TODO Might not be required later on
			]);

			$videoQuestionDefinition->save();
			$videoQuestionDragAndDrop->save();
			
			// Add an entry to the pivot table
			$quiz->videoQuestions()->attach($videoQuestionDefinition->id);
			$quiz->videoQuestions()->attach($videoQuestionDragAndDrop->id);
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
		// Check if a reminder quiz has been created but not attempted
		$quiz = Quiz::where('quizzes.user_id', '=', $user_id)
					->where('quizzes.category_type', '=', 'LangLeap\Quizzes\ReminderQuiz')
					->join('reminder_quizzes', 'quizzes.category_id', '=', 'reminder_quizzes.id')
					->where('reminder_quizzes.attempted', '=', false)->first();
		
		if(!$quiz)
		{
			$category = ReminderQuiz::create(['attempted' => false]);
			
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
				$quiz = Quiz::create([
					'user_id' => $user_id,
					'category_id'		=> $category->id,
					'category_type'	=> 'LangLeap\Quizzes\ReminderQuiz',
				]);
				
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
		else
		{
			return $quiz;
		}
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
		$randomWords = $this->getRandomWordsWithDefinition($wordInformation->getWord(), $numAnswers, $videoId);
		$question = QuestionFactory::getInstance()->getDefinitionQuestion($questionPrepend, $wordInformation);

		$correctAnswer = Answer::create([
			'question_id' => $question->id,
			'answer'      => $wordInformation->getDefinition()
		]);
		$correctAnswer->save();

		$question->answer_id = $correctAnswer->id;
		$question->save();

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
	 * Creates a new drag and drop question with a set amount of answers
	 *
	 * @param  string  	   $definition
	 * @param  int         $numAnswers
	 * @param  int         $videoId
	 * @return Question
	 */
	protected function createDragAndDropQuestion($wordInformation, $numAnswers, $videoId)
	{
		$randomWords = $this->getRandomWords($wordInformation->getWord(), $numAnswers, $videoId);
		$question = QuestionFactory::getInstance()->getDragAndDropQuestion($wordInformation);

		$correctAnswer = Answer::create([
			'question_id' => $question->id,
			'answer'      => $wordInformation->getWord()
		]);
		$correctAnswer->save();

		$question->answer_id = $correctAnswer->id;
		$question->save();

		foreach($randomWords as $randomWord)
		{
			$answer = Answer::create([
				'question_id' => $question->id,
				'answer'      => $randomWord
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
	private function getRandomWordsWithDefinition($correctWord, $numAnswers, $videoId)
	{
		$words = $this->getWordsFromRandomScript();

		$randomWords = array();

		// Get 3 words with length > 3 which are different than the word in the question
		foreach($words as $word)
		{
			if($correctWord != $word && !in_array($word, $randomWords) && strlen($word) > 3)
			{
				// Get the definition of the word, if successful push into the array
				$wordInformation = new WordInformation($word, '', '', $videoId);
				if($wordInformation->getDefinition()) 
				{
					array_push($randomWords, $wordInformation);
				}
			}

			if(count($randomWords) == $numAnswers - 1) return $randomWords;
		}

		return $randomWords;
	}

	/**
	 * Creates an array of random words to put as incorrect answers
	 *
	 * @param  int         $numAnswers
	 * @return array
	 */
	private function getRandomWords($correctWord, $numAnswers, $videoId)
	{
		
		$words = $this->getWordsFromRandomScript();

		$randomWords = array();
		// Get 3 words with length > 3 which are different than the word in the question
		foreach($words as $word)
		{
			if($correctWord != $word && strlen($word) > 3)
			{
				array_push($randomWords, $word);
			}

			if(count($randomWords) == $numAnswers - 1) return $randomWords;
		}

		return $randomWords;
	}

	/**
	 * This function will get one script, and gather the words from that script.
	 */
	private function getWordsFromRandomScript()
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

		return $words;
	}

	/**
	 *
	 * @param  int 		$video_id
	 * @return string 	
	 *
	 */
	protected function getNextVideoPath($video_id)
	{
		$video = Video::find($video_id);

		if(! $video)
		{
			return "/";
		}
		else
		{
			//Get the next video in the sequence
			$next_video = $video->nextVideo();

			if(! $next_video)
			{
				return "/";
			}

			return "/video/play/" . $next_video->id;
		}
	}
}
