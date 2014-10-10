<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class ApiVideoControllerTest extends TestCase {

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
}
