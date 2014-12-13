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
	
	public function testVideoRelation()
	{
		$quiz = $this->getQuizInstance();
		$video = $this->getVideoInstance();
		
		$quiz->video_id = $video->id;
		$quiz->save();
		
		$this->assertCount(1, $quiz->video()->get());
	}
	
	protected function getQuizInstance()
	{
		return App::make('LangLeap\Quizzes\Quiz');
	}
	
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$video->path = '/path/to/somewhere';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->save();
		return $video;
	}
}
