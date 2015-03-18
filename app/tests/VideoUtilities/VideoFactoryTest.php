<?php

use LangLeap\TestCase;
use LangLeap\VideoUtilities\VideoFactory;
use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Episode;
use LangLeap\Core\Language;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class VideoFactoryTest extends TestCase {
	
	public function testGetInstance()
	{
		$factory = VideoFactory::getInstance();

		$this->assertInstanceOf('LangLeap\VideoUtilities\VideoFactory', $factory);
	}

	public function testCreateVideo()
	{
		
		$this->seed();

		$commercial = Commercial::first();
		$language = Language::first();

		$video = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', 
			'1.mkv',
			'video/x-matroska',
			null,
			null,
			true);

		$text = "text";

		$input =  [
				'media_type'	=> 'commercial',
				'media_id'		=> $commercial->id, 
				'language_id' 	=> $language->id, 
				"script" 		=> $text,
				'video'=> $video
			];

		$factory = VideoFactory::getInstance();

		$video = $factory->createVideo($input);

		$this->assertInstanceOf("LangLeap\Videos\Video", $video);
	}
	
	public function testSetScript()
	{
		$this->seed();

		$script_text = 'test';

		$video = Video::first();

		$factory = VideoFactory::getInstance();

		$factory->setScript($script_text, $video->id, $video->script);

		$this->assertEquals($script_text, $video->script()->first()->text);
	}

	public function testSetVideoWithCommercial()
	{
		$this->seed();

		$commercial = Commercial::first();
		$language = Language::first();

		$video = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', 
			'1.mkv',
			'video/x-matroska',
			null,
			null,
			true);

		$input =  [
				'media_type'	=> 'commercial',
				'media_id'		=> $commercial->id, 
				'language_id' 	=> $language->id, 
				'video'=> $video
			];

		$factory = VideoFactory::getInstance();

		$video = $factory->setVideo($input);

		$this->assertInstanceOf("LangLeap\Videos\Video", $video);
	}

	public function testSetVideoWithMovie()
	{
		$this->seed();

		$commercial = Commercial::first();
		$language = Language::first();

		$video = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', 
			'1.mkv',
			'video/x-matroska',
			null,
			null,
			true);

		$input =  [
				'media_type'	=> 'movie',
				'media_id'		=> $commercial->id, 
				'language_id' 	=> $language->id, 
				'video'=> $video
			];

		$factory = VideoFactory::getInstance();

		$video = $factory->setVideo($input);

		$this->assertInstanceOf("LangLeap\Videos\Video", $video);
	}

	public function testSetVideoWithShow()
	{
		$this->seed();

		$commercial = Commercial::first();
		$language = Language::first();

		$video = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.mkv', 
			'1.mkv',
			'video/x-matroska',
			null,
			null,
			true);

		$input =  [
				'media_type'	=> 'show',
				'media_id'		=> $commercial->id, 
				'language_id' 	=> $language->id, 
				'video'=> $video
			];

		$factory = VideoFactory::getInstance();

		$video = $factory->setVideo($input);

		$this->assertInstanceOf("LangLeap\Videos\Video", $video);
	}

}
