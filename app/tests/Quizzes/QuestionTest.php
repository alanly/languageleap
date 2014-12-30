<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class QuestionTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testAnswerRelation()
	{
		$question = $this->getQuestionInstance();
		$answer = $this->getAnswerInstance();
		$question->question = '';
		$question->answer_id = $answer->id;
		$question->save();
	
		$this->assertCount(1, $question->answers()->get());	
	}
	
	protected function getAnswerInstance()
	{
		$answer = App::make('LangLeap\Quizzes\Answer');
		$answer->question_id = 1; // un-needed id
		$answer->answer = ''; //un-needed id
		$answer->save();
		return $answer;
	}	

	protected function getQuestionInstance()
	{
		return App::make('LangLeap\Quizzes\Question');
	}
}
