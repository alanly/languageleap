<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class VideoTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testScriptRelation()
	{
		$commercial = $this->getCommercialInstance();
		$script = $this->getScriptInstance();

		$video = $this->getVideoInstance();
		$video->path='/path/to/somewhere';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
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
		$comm->name='Test';
		$comm->save();

		return $comm;
	}
}
