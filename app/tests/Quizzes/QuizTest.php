<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*		@author Quang Tran <tran.quang@live.com>
*/
class QuizTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}
	
	public function testVideoQuestionRelation()
	{
		$quiz = $this->getQuizInstance();
		$quiz->save();
		
		$vq = $this->getVideoQuestionInstance();
		$quiz->videoQuestions()->attach($vq->id);
		
		$this->assertCount(1, $quiz->videoQuestions()->get());
	}
	
	protected function getQuizInstance()
	{
		return App::make('LangLeap\Quizzes\Quiz');
	}
	
	protected function getVideoQuestionInstance()
	{
		$videoQuestion = App::make('LangLeap\Quizzes\VideoQuestion');
		$videoQuestion->question_id = 1;
		$videoQuestion->video_id = 1;
		$videoQuestion->is_custom = true;
		$videoQuestion->save();

		return $videoQuestion;
	}
}
