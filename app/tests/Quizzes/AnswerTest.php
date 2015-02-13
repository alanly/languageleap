<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*	@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class AnswerTest extends TestCase {

	public function testQuestionRelation()
	{
		$answer = $this->getAnswerInstance();
		$question = $this->getQuestionInstance();
		$answer->answer = '';
		$answer->question_id = $question->id;
		$answer->save();
		$question->answer_id = $answer->id;
		$question->save();
	
		$this->assertCount(1, $answer->question()->get());	
	}
	
	protected function getQuestionInstance()
	{
		$question = App::make('LangLeap\Questions\Question');
		$question->question_type = 'LangLeap\Questions\DefinitionQuestion';
		$question->question_id = 1;
		$question->answer_id = -1;
		$question->save();
		return $question;
	}	

	protected function getAnswerInstance()
	{
		return App::make('LangLeap\Quizzes\Answer');
	}
}
