<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Episode;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class ApiVideoControllerTest extends TestCase {

	public function testShow()
	{
		$this->seed();
		$video = Video::first();
		$response = $this->action(
			'get',
			'ApiVideoController@show',
			[$video->id]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('video', $data);

	}
	public function testStore()
	{
		$this->seed();
		$commercial = Commercial::first();
		
		$video = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', '1.mkv','video/x-matroska',null,null,true);
		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.txt', '1.txt');

		$response = $this->action(
			'POST',
			'ApiVideoController@store',
			[],['video_type'=>'commercial','commercial'=>$commercial->id],
			['video'=> $video, 'script' => $script]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}
	public function testUpdate()
	{
		$this->seed();
		$episode = Episode::first();
		$video = Video::first();

		$video_file = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', '1.mkv','video/x-matroska',null,null,true);
		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.txt', '1.txt');

		$response = $this->action(
			'PATCH',
			'ApiVideoController@update',
			[$video->id],['video_type'=>'episode','episode'=>$episode->id],
			['video'=> $video_file, 'script' => $script]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

	}
	public function testDestroy()
	{
		$this->seed();
		$video = Video::first();
		$id = $video->id;
		$response = $this->action(
			'DELETE',
			'ApiVideoController@destroy',
			[$id]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		$this->assertNull(Video::find($id));
	}
}
