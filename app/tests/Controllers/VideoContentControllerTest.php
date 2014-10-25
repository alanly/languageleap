<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use Mockery as m;

class VideoContentControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}


	public function testGetVideo()
	{
		// Get the first video entry.
		$video = Video::first();

		$path = Config::get('media.test').'/1.mkv';

		// Get a mock SplFileInfo instance
		$fileInfo = $this->getMockFileInstance();
		$fileInfo->shouldReceive('isFile')->once()->andReturn(true);
		$fileInfo->shouldReceive('isReadable')->once()->andReturn(true);
		$fileInfo->shouldReceive('getRealPath')->once()->andReturn($path);
		$fileInfo->shouldReceive('getFilename')->once()->andReturn('1.mkv');
		$fileInfo->shouldReceive('getPathname')->once()->andReturn($path);

		// Mock the FileInfoFactory
		$fileInfoFactory = m::mock('LangLeap\Core\FileInfoFactory');
		$fileInfoFactory->shouldReceive('makeInstance')->once()->andReturn($fileInfo);
		App::instance('LangLeap\Core\FileInfoFactory', $fileInfoFactory);

		// Call the route appropriately.
		$response = $this->action('GET', 'VideoContentController@getVideo', [$video->id]);

		$this->assertResponseOk();
		$this->assertEquals($path, $response->headers->get('X-Sendfile'));
		$this->assertEquals($path, $response->headers->get('X-LIGHTTPD-send-file'));
		$this->assertStringEndsWith('/1.mkv', $response->headers->get('X-Accel-Redirect'));
	}


	public function testGetVideoWithInvalidId()
	{
		$response = $this->action('GET', 'VideoContentController@getVideo', [0]);

		$this->assertResponseStatus(404);
	}


	public function testGetVideoWithBadFile()
	{
		// Get the first video entry.
		$video = Video::first();

		// Get a mock SplFileInfo instance
		$fileInfo = $this->getMockFileInstance();
		$fileInfo->shouldReceive('isFile')->once()->andReturn(false);
		$fileInfo->shouldReceive('isReadable')->once()->andReturn(true);

		// Mock the FileInfoFactory
		$fileInfoFactory = m::mock('LangLeap\Core\FileInfoFactory');
		$fileInfoFactory->shouldReceive('makeInstance')->once()->andReturn($fileInfo);
		App::instance('LangLeap\Core\FileInfoFactory', $fileInfoFactory);

		// Call the route appropriately.
		$response = $this->action('GET', 'VideoContentController@getVideo', [$video->id]);

		$this->assertResponseStatus(500);
	}


	protected function getMockFileInstance()
	{
		return m::mock('\SplFileInfo');
	}
	
}
