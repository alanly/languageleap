<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class AnswerTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testQuestionRelation()
	{
		$answer = $this->getAnswerInstance();
		$question = $this->getQuestionInstance();
		$answer->answer = '';
		$answer->question_id = $question->id;
		$answer->save();
	
		$this->assertCount(1, $answer->question()->get());	
	}
	
	protected function getQuestionInstance()
	{
		$question = App::make('LangLeap\Quizzes\Question');
		$question->answer_id = 1; // un-needed id
		$question->question = ''; //un-needed id
		$question->save();
		return $question;
	}	

	protected function getAnswerInstance()
	{
		return App::make('LangLeap\Quizzes\Answer');
	}
}
