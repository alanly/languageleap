<?php namespace LangLeap\Quizzes;

use LangLeap\Videos\Video;
use LangLeap\TestCase;
use App;


/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class VideoQuestionTest extends TestCase {


	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testVideoRelation()
	{
		$videoQuestion = $this->getVideoQuestionInstance();
		$video = Video::first();
		$videoQuestion->video_id = $video->id;
		$videoQuestion->question_id = 1;
		$videoQuestion->quiz_id = 1;
		$videoQuestion->is_custom = false;
		$videoQuestion->save();
		$this->assertCount(1, $videoQuestion->video()->get());
	}

	public function testQuestionRelation()
	{
		$videoQuestion = $this->getVideoQuestionInstance();
		$question = $this->getQuestionInstance();
		$videoQuestion->video_id = 1;
		$videoQuestion->question_id = $question->id;
		$videoQuestion->quiz_id = 1;
		$videoQuestion->is_custom = false;
		$videoQuestion->save();
	
		$this->assertCount(1, $videoQuestion->question()->get());
	}
	
	public function testQuizRelation()
	{
		$videoQuestion = $this->getVideoQuestionInstance();
		$quiz = $this->getQuizInstance();
		$videoQuestion->video_id = 1;
		$videoQuestion->question_id = 1;
		$videoQuestion->quiz_id = $quiz->id;
		$videoQuestion->is_custom = false;
		$videoQuestion->save();
	
		$this->assertCount(1, $videoQuestion->quiz()->get());
	}

	protected function getQuestionInstance()
	{
		$question = App::make('LangLeap\Quizzes\Question');
		$question->question = '';
		$question->answer_id = 1;
		$question->save();

		return $question;
	}	
	
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$video->path = '';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->save();

		return $video;
	}	

	protected function getQuizInstance()
	{
		$quiz = App::make('LangLeap\Quizzes\Quiz');
		$quiz->save();

		return $quiz;
	}
	
	protected function getVideoQuestionInstance()
	{
		return App::make('LangLeap\Quizzes\VideoQuestion');
	}
}
