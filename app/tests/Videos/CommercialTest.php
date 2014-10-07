<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class CommercialTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testVideoRelation()
	{
		$comm = $this->getCommercialInstance();
		$script = $this->getScriptInstance();
		$video  = $this->getVideoInstance();
		$video->viewable_id = $comm->id;
		$video->viewable_type = 'LangLeap\Videos\Commercial';
		$video->save();

		$script->text = '';
		$script->video_id = $video->id;
		$script->save();
		
		$this->assertCount(1, $comm->videos()->get());			
	}
	protected function getCommercialInstance()
	{
		$comm =  App::make('LangLeap\Videos\Commercial');
		$comm->name = 'Test Commercial';
		$comm->save();
		return $comm;
	}
	protected function getVideoInstance()
	{
		$video =  App::make('LangLeap\Videos\Video');
		$video->path = '/path/to/somewhere';
		return $video;
	}
	
	protected function getScriptInstance()
	{
		return App::make('LangLeap\Words\Script');
	}	

}
