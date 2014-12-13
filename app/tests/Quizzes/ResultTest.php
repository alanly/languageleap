<?php namespace LangLeap\Quizzes;

use LangLeap\TestCase;
use App;


/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class ResultTest extends TestCase {

	public function testVideoQuestionRelation()
	{
		$result = $this->getResultInstance();
		$videoQuestion = $this->getVideoQuestionInstance();
		$result->videoquestion_id = $videoQuestion->id;
		$result->is_correct = true;
		$result->timestamp = time();
		$result->save();
	
		$this->assertCount(1, $result->videoquestion()->get());
	}
	
	public function testUserRelation()
	{
		$result = $this->getResultInstance();
		$user = $this->getUserInstance();
		$result->user_id = $user->id;
		$result->videoquestion_id = 1;
		$result->is_correct = true;
		$result->timestamp = time();
		$result->save();
		
		$this->assertCount(1, $result->user()->get());
	}
	
	protected function getVideoQuestionInstance()
	{
		$videoQuestion = App::make('LangLeap\Quizzes\VideoQuestion');
		$videoQuestion->question_id = 1;
		$videoQuestion->quiz_id = 1;
		$videoQuestion->is_custom = true;
		$videoQuestion->save();

		return $videoQuestion;
	}

	protected function getUserInstance()
	{
		$this->seed('UserTableSeeder');
		return \LangLeap\Accounts\User::first();
	}

	protected function getResultInstance()
	{
		return App::make('LangLeap\Quizzes\Result');
	}
}
