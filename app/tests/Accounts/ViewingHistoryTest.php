<?php namespace LangLeap\Accounts;

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use App;

/**
 * This class is used to test the relations between ViewingHistory and User/Video
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class ViewingHistoryTest extends TestCase {
	
	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}


	public function testUserRelation()
	{
		$history = $this->getViewingHistoryInstance();
		$user = User::first();
		
		$history->user_id = $user->id;
		$history->video_id = 1; //Video is not important for this test.
		$history->is_finished = false;
		$history->current_time = 5;
		$history->save();

		$this->assertCount(1, $history->user()->get());

	}


	public function testVideoRelation()
	{
		$history = $this->getViewingHistoryInstance();
		$video = Video::first();
		
		$history->user_id = 1; //User is not important for this test.
		$history->video_id = $video->id; 
		$history->is_finished = false;
		$history->current_time = 5;
		$history->save();

		$this->assertCount(1, $history->video()->get());
	}


	protected function getViewingHistoryInstance()
	{
		return App::make('LangLeap\Accounts\ViewingHistory');
	}

}
