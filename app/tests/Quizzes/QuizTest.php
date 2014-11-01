<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;

class QuizTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testQuestionsRelation()
	{
		$user = $this->getUserInstance();
		$video = $this->getVideoInstance();
		$quiz = $this->getQuizInstance();
		$question = $this->getQuestionInstance();
		$quiz->user_id = $user->id;
		$quiz->video_id = $video->id;	
		$quiz->save();
		$question->quiz_id = $quiz->id;	
		$question->save();
		$this->assertCount(1, $quiz->questions()->get());			
	}
	protected function getQuizInstance()
	{
		return App::make('LangLeap\Quizzes\Quiz');
	}	
	protected function getUserInstance()
	{
		$user = App::make('LangLeap\Accounts\User');
		$user->username = '';
		$user->email = '';
		$user->first_name = '';
		$user->last_name = '';
		$user->password = '';
		$user->save();
		return $user;
	}
	protected function getQuestionInstance()
	{
		$question =  App::make('LangLeap\Quizzes\Question');
		$question->question = '';
		$question->answer = '';
		$question->script_word_id = 1;
		return $question;
	}
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$comm = App::make('LangLeap\Videos\Commercial');
		$comm->name = 'Test';
		$comm->save();
		$video->viewable_id = $comm->id;
		$video->viewable_type = 'LangLeap\Videos\Commercial';		
		$video->path = '/path/to/somewhere';
		$video->save();
		return $video;
	}
	

}
