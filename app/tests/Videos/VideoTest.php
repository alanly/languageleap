<?php

use LangLeap\TestCase;

class VideoTest extends TestCase {

	public function testScriptRelation()
	{
		$commercial = $this->getCommercialInstance();
		$script = $this->getScriptInstance();
		$video = $this->getVideoInstance();
		$lang = $this->getLanguageInstance();

		$video->path = '/path/to/somewhere';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->language_id = $lang->id;
		$video->level_id = 1;
		$video->save();
		
		$script->video_id = $video->id;
		$script->save();
		
		$this->assertCount(1, $video->script()->get());			
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

	protected function getCommercialInstance()
	{
		$comm = App::make('LangLeap\Videos\Commercial');
		$comm->name = 'Test';
		$comm->save();

		return $comm;
	}
	
	protected function getLanguageInstance()
	{
		$lang = App::make('LangLeap\Core\Language');
		$lang->code = 'en';
		$lang->description = 'English';
		$lang->save();

		return $lang;
	}

}
