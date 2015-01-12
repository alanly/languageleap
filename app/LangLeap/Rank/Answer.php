<?php namespace LangLeap\Rank;

use LangLeap\Quizzes\Answer as VideoAnswer;

/**
 * A ranking quiz-question answer reprsentation structure.
 * @author Alan Ly <hello@alan.ly>
 */
class Answer {

	public $id;
	public $text;


	/**
	 * Creates a new Answer instance from a given `LangLeap\Quizzes\Answer`.
	 * @param  LangLeap\Quizzes\Answer  $videoAnswer
	 * @return Answer
	 */
	public static function createFromVideoAnswer(VideoAnswer $videoAnswer)
	{
		// Create a new instance of self.
		$answer = App::make('LangLeap\Rank\Answer');

		// Map the attributes.
		$answer->id = $videoAnswer->id;
		$answer->text = $videoAnswer->answer;

		return $answer;
	}
	
}
