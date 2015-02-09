<?php

use LangLeap\TestCase;

class VideoTest extends TestCase {

	public function testScriptRelation()
	{
		$script = $this->getScriptInstance();
		$video = $this->getVideoInstance();

		$video->path = '/path/to/somewhere';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->language_id = 1;
		$video->save();
		
		$script->video_id = $video->id;
		$script->save();
		
		$this->assertCount(1, $video->script()->get());			
	}

	public function testGetNextVideo()
	{
		$video1 = $this->getVideoInstance();

		$video1->path = '/path/to/somewhere';
		$video1->viewable_id = 1;
		$video1->viewable_type = 'LangLeap\Videos\Commercial';
		$video1->language_id = 1;
		$video1->video_number = 1;
		$video1->save();

		$video2 = $this->getVideoInstance();

		$video2->path = '/path/to/somewhere';
		$video2->viewable_id = 1;
		$video2->viewable_type = 'LangLeap\Videos\Commercial';
		$video2->language_id = 1;
		$video2->video_number = 2;
		$video2->save();

		$this->assertEquals($video2->id, $video1->nextVideo()->id);
	}
	
	public function testGetNullNextVideo()
	{
		$video = $this->getVideoInstance();

		$video->path = '/path/to/somewhere';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->language_id = 1;
		$video->video_number = 4;
		$video->save();

		$this->assertNull($video->nextVideo());
	}
	
	protected function getVideoInstance()
	{
		return App::make('LangLeap\Videos\Video');
	}

	protected function getScriptInstance()
	{
		$script = App::make('LangLeap\Words\Script');
		$script->text = 'This is a test';
		return $script;
	}
}
