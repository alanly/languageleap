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
		
		$vq = $this->getVideoQuestionInstance();
		$quiz->videoQuestions()->attach($vq->id);
		
		$this->assertCount(1, $quiz->videoQuestions()->get());
	}
	
	public function testMorphToVideoQuizRelation()
	{
		$quiz = $this->getQuizInstance();
		
		$category = $this->getCategoryVideoInstance();
		
		$quiz->category_id = $category->id;
		$quiz->category_type = 'LangLeap\Quizzes\VideoQuiz';
		$quiz->save();
		
		$this->assertEquals(1, $quiz->category->video_id);
	}
	
	public function testMorphToReminderQuizRelation()
	{
		$quiz = $this->getQuizInstance();
		
		$category = $this->getCategoryReminderInstance();
		
		$quiz->category_id = $category->id;
		$quiz->category_type = 'LangLeap\Quizzes\ReminderQuiz';
		$quiz->save();
		
		$this->assertEquals(false, (boolean)$quiz->category->attempted);
	}
	
	protected function getQuizInstance()
	{
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$quiz->category_id = 1;
		$quiz->category_type = 'LangLeap\Quizzes\VideoQuiz';
		$quiz->save();
		
		return $quiz;
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
	
	protected function getCategoryVideoInstance()
	{
		$category = App::make('LangLeap\Quizzes\VideoQuiz');
		$category->video_id = 1;
		$category->save();
		
		return $category;
	}
	
	protected function getCategoryReminderInstance()
	{
		$category = App::make('LangLeap\Quizzes\ReminderQuiz');
		$category->attempted = false;
		$category->save();
		
		return $category;
	}
}
