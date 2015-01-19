<?php 

use LangLeap\TestCase;

/**
*		@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*/
class ApiCutVideoTest extends TestCase {

	private $commercial;
	private $video;

	public function setUp()
	{
		parent::setUp();
		$this->commercial = $this->getCommercialInstance();
		$this->video = $this->getVideoInstance();
		$this->be($this->getUserInstance(true));
	}

	public function testCutVideoUnauthorized()
	{	
		$this->be($this->getUserInstance(false));
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], [
				"video_id" => $this->video->id, 
				"segments" => [['time' => 10, 'duration' => 10], ['time' => 20, 'duration' => 10]]
			]
		);
		$this->assertResponseStatus(401);
	}
	
	public function testCutVideoMissingVideo()
	{	
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], [
				"segments" => [['time' => 10, 'duration' => 10], ['time' => 20, 'duration' => 10]]
			]
		);
		$this->assertResponseStatus(400);
	}
	
	public function testCutVideoMissingSegments()
	{	
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], ["video_id" => $this->video->id]
		);
		$this->assertResponseStatus(400);
	}
	
	public function testCutVideoVideoNotFound()
	{	
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], [
				"video_id" => -1, 
				"times" => [['time' => 10, 'duration' => 10], ['time' => 20, 'duration' => 10]]
			]
		);
		$this->assertResponseStatus(404);
	}
	
	public function testCutVideoMalformedSegments()
	{	
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], [
				"video_id" => $this->video->id,
				"segments" => []
			]
		);
		$this->assertResponseStatus(400);
		
		$response = $this->action(
			'POST', 'ApiCutVideoController@postSegments', 
			[], [
				"video_id" => $this->video->id,
				"segments" => [['time' => 10, 'duration' => 10], ['time' => 20, 'abc' => -10]]
			]
		);
		$this->assertResponseStatus(400);
	}
	
	protected function getVideoInstance()
	{
		$video = App::make('LangLeap\Videos\Video');
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\\Videos\\Commercial';
		$video->language_id = 1;
		$video->path = 'storage' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . 'commercials' . DIRECTORY_SEPARATOR . 'test.mp4';
		$video->save();

		return $video;
	}	

	protected function getCommercialInstance()
	{
		$commercial = App::make('LangLeap\Videos\Commercial');
		$commercial->name = 'TedTalks';
		$commercial->description ='Vacation';
		$commercial->level_id = 1;
		$commercial->save();
		
		return $commercial;
	}
	
	protected function getUserInstance($is_admin)
	{
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = 'password';
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = $is_admin;
		
		return $user;
	}
}
