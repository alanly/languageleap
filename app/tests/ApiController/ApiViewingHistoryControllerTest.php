<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use LangLeap\Accounts\ViewingHistory;
use LangLeap\Videos\Video;

/*
 * @author Thomas Rahn <thomas@rahn.ca>
 *
 * This test class will test the Viewing History API
 */
class ApiViewingHistoryControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}
	/*
	 * This test will test that you are able to access the viewing history API.
	 */
	public function testGetViewingHistory()
	{
		$this->be(User::first());
		$video_id = Video::first()->id;
		$response = $this->action('GET', 'ApiViewingHistoryController@getIndex',[],['video_id' => $video_id]);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}

	/*
	 * This test will test to see if no video is sent that it will show the proper error messages
	 */
	public function testGetViewingHistoryWithNoVideo()
	{
		$this->be(User::first());
		$response = $this->action('GET', 'ApiViewingHistoryController@getIndex');
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testGetViewingHistoryWithNoHistory()
	{
		$this->be(User::first());
		$video_id = Video::first()->id;
		$response = $this->action('GET', 'ApiViewingHistoryController@getIndex',[],['video_id' => $video_id]);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData();

		$this->assertEquals(0, $data->data->current_time);
	}

	public function testUpdateViewingHistory()
	{
		$user = User::first();

		$this->be($user);
		$video_id = Video::first()->id;

		$history = $this->createViewingHistory($user->id, $video_id);

		$response = $this->action('POST', 'ApiViewingHistoryController@postIndex',[],['video_id' => $video_id, 'current_time' => 5]);

		$this->assertResponseOk();
	}

	protected function createViewingHistory($user_id, $video_id)
	{
		$history = ViewingHistory::create([
			'user_id' 	=> $user_id,
			'video_id' 	=> $video_id,
			'current_time' 	=> 0,
			'is_finished' 	=> false
		]);

		return $history;
	}
}
