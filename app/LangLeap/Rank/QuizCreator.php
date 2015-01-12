<?php namespace LangLeap\Rank;

use LangLeap\Quizzes\VideoQuestion;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class QuizCreator {

	protected $videoQuestions;


	public function __construct(VideoQuestion $videoQuestions)
	{
		$this->videoQuestions = $videoQuestions;
	}


	public function createQuiz(QuizCreationListener $listener)
	{
		return $listener->quizCreated($this->generateNewQuiz());
	}


	protected function generateNewQuiz()
	{
		// Create a new quiz instance.
		$quiz = App::make('LangLeap\Rank\Quiz');
		
		// Get the questions for ranking.
		$videoQuestions = $this->retrieveVideoQuestions();

		// Populate the quiz struct with the questions.
		$quiz = $this->populateQuizFromVideoQuestions($quiz, $videoQuestions);

		return $quiz;
	}


	/**
	 * Retrieves a collection of the VideoQuestions which are specifically meant
	 * for ranking purposes.
	 * @return \Traversable
	 */
	protected function retrieveVideoQuestions()
	{
		// @NOTICE The video questions for the ranking/tutorial is determined based
		//         upon the file path of the video. This is a pretty bad way of
		//         doing things. Ideally, we'll find another method of categorizing
		//         videos or video questions.
		$videoQuestions = $this->videoQuestions
			->join('videos', 'videos.id', '=', 'videoquestions.video_id')
			->where('videos.path', '/path/to/tutorial/video.mkv')
			->get();

		return $videoQuestions;
	}


	/**
	 * Given a Quiz instance and a traverasble collection of VideoQuestions, this
	 * method will populate the quiz with the respective Question instances.
	 * @param  Quiz         $quiz           [description]
	 * @param  \Traversable $videoQuestions [description]
	 * @return Quiz
	 */
	protected function populateQuizFromVideoQuestions(Quiz $quiz, \Traversable $videoQuestions)
	{
		// Create the question instance.
		$questionInstance = App::make('LangLeap\Rank\Question');

		// Populate the quiz's questions collection.
		foreach ($videoQuestions as $vq)
		{
			$quiz->questions->push($questionInstance::createFromVideoQuestion($vq));
		}

		return $quiz;
	}
	
}
