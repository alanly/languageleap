<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use App;

class QuizTest extends TestCase {

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
		$this->seed();
		return User::first();
	}

	protected function getQuestionInstance()
	{
		$question =  App::make('LangLeap\Quizzes\Question');
		$question->question = '';
		$question->selected_id = 1; //un-need id
		$question->definition_id = 1; //un-need id
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
