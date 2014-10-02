<?php namespace LangLeap\Words;

use LangLeap\TestCase;
use App;

class ScriptTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testVideoRelation()
	{
		$script = $this->getScriptInstance();
		$script->text='';
		$video = $this->getVideoInstance();
		$video->path='';
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->save();
		$script->video_id = $video->id;
		$script->save();
		$this->assertCount(1, $script->video()->get());
	
	}
	protected function getVideoInstance()
	{
		return App::make('LangLeap\Videos\Video');
	}
	protected function getScriptInstance()
	{
		return App::make('LangLeap\Words\Script');
	}
	

}
