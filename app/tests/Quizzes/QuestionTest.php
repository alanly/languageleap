<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;

class QuestionTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testQuizRelation()
	{
		$question = $this->getQuestionInstance();
		$quiz = $this->getQuizInstance();
		$question->question = '';
		$question->answer = '';
		$question->quiz_id = $quiz->id;
		$question->script_word_id = 1;
		$question->save();
	
		$this->assertCount(1, $question->quiz()->get());			
	}
	public function testScriptWordRelation()
	{
		$question = $this->getQuestionInstance();
		$script_w = $this->getScriptWordInstance();
                $question->question = '';
                $question->answer = '';
                $question->quiz_id = 1;
                $question->script_word_id = $script_w->id;
                $question->save();
		$this->assertCount(1, $question->script_word()->get());


	}
	protected function getQuizInstance()
	{
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$quiz->user_id = 1; // un-needed id
                $quiz->video_id = 1; //un-needed id
                $quiz->save();
		return $quiz;

	}	
	protected function getQuestionInstance()
	{
		return App::make('LangLeap\Quizzes\Question');
	}
	protected function getScriptWordInstance()
	{
		$script_w = App::make('LangLeap\Words\Script_Word');
		$script_w->word_id = 1;
		$script_w->script_id =1;
		$script_w->position =1;
		$script_w->save();
		return $script_w;
	}
}
