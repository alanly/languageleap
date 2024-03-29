<?php

use LangLeap\TestCase;
use LangLeap\CutVideoUtilities\CutVideoResponse;

class CutVideoResponseTest extends TestCase {

	private $videoPath;
	private $viewableType;

	public function __construct()
	{
		$this->videoPath = 'storage' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . 'commercials' . DIRECTORY_SEPARATOR . 'test.mp4';
		$this->viewableType = 'LangLeap\Videos\Commercial';
	}
	
	public function testResponse()
	{
		$cutVideoAdapter = $this->getMockBuilder('LangLeap\CutVideoUtilities\ICutVideoAdapter')->getMock();
		
		$videos = [];
		array_push($videos, $this->getVideoInstance());
		
		$cutVideoAdapter->method('cutVideoByTimes')->willReturn($videos);
		
		$videoResponse = new CutVideoResponse($cutVideoAdapter);
		
		$response = $videoResponse->response($this->getUserInstance(), ['video_id' => 1, 'segments' => [['time' => 10, 'duration' => 10]]]);

		$this->assertCount(3, $response);
		$this->assertInternalType('string', $response[0]);
		$this->assertInternalType('array', $response[1]);
		$this->assertInternalType('int', $response[2]);
		
		$this->assertGreaterThan(0, count($response[1]));
		
		$this->assertArrayHasKey('id', $response[1][0]);
		$this->assertEquals(1, $response[1][0]['viewable_id']);
		$this->assertEquals($this->viewableType, $response[1][0]['viewable_type']);
		$this->assertArrayHasKey('script', $response[1][0]);
	}
	
	public function testResponseException()
	{
		$cutVideoAdapter = $this->getMockBuilder('LangLeap\CutVideoUtilities\ICutVideoAdapter')->getMock();
		
		$cutVideoAdapter->method('cutVideoByTimes')->will($this->throwException(new Exception));
		
		$videoResponse = new CutVideoResponse($cutVideoAdapter);
		
		$response = $videoResponse->response($this->getUserInstance(), ['video_id' => $this->getVideoInstance()->id, 'segments' => [['times' => 10, 'duration' =>10]]]);
		$this->assertCount(3, $response);
		$this->assertInternalType('string', $response[0]);
		$this->assertInternalType('string', $response[1]);
		$this->assertInternalType('int', $response[2]);
		
		$this->assertEquals(500, $response[2]);
	}
	
	protected function getVideoInstance()
	{
		$viewable = App::make('LangLeap\Videos\Commercial');
		$viewable->name = 'Test Commercial';
		$viewable->description = 'test';
		$viewable->is_published = true;
		$viewable->save();
		
		$video = App::make('LangLeap\Videos\Video');
		$video->viewable_id = $viewable->id;
		$video->viewable_type = $this->viewableType;
		$video->language_id = 1;
		$video->path = $this->videoPath;
		$video->save();
		
		$script = App::make('LangLeap\Words\Script');
		$script->text = 'test script';
		$script->video_id = $video->id;
		$script->save();
		
		return $video;
	}
	
	protected function getUserInstance()
	{
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = 'password';
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = true;
		
		return $user;
	}
}