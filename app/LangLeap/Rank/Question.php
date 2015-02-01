<?php namespace LangLeap\Rank;

use App;
use LangLeap\Core\Collection;
use LangLeap\Quizzes\VideoQuestion;

/**
 * A ranking quiz question representation structure.
 * @author Alan Ly <hello@alan.ly>
 */
class Question {

	public    $id;
	public    $text;
	public    $answers;
	protected $collection;


	public function __construct(Collection $collection)
	{
		$this->collection = $collection;

		$this->answers = new Collection;
	}


	/**
	 * Creates a new Question instance from a given VideoQuestion.
	 * @param  VideoQuestion $videoQuestion
	 * @return Question
	 */
	public static function createFromVideoQuestion(VideoQuestion $videoQuestion)
	{
		// Create a new instance of self.
		$question = App::make('LangLeap\Rank\Question');

		// Reference the actual question held by the VideoQuestion
		$videoQuestion = $videoQuestion->question;

		// Map the instance values.
		$question->id = $videoQuestion->id;
		$question->text = $videoQuestion->questionType->question();

		// Gather the possible answers for the question.
		$videoAnswers = $videoQuestion->answers;

		// Create an instance of our Answer struct.
		$answerInstance = App::make('LangLeap\Rank\Answer');

		foreach ($videoAnswers as $va)
		{
			$question->answers->push($answerInstance::createFromVideoAnswer($va));
		}

		return $question;
	}
	
}
