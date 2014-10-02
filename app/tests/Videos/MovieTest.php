<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class MovieTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testVideoRelation()
	{
		$mov = $this->getMovieInstance();
		$script = $this->getScriptInstance();
		$video  = $this->getVideoInstance();
		$video->viewable_id = $mov->id;
		$video->viewable_type = 'LangLeap\Videos\Movie';
		$video->save();

		$script->text = '';
		$script->video_id = $video->id;
		$script->save();
		
		$this->assertCount(1, $mov->videos()->get());			
	}
	protected function getMovieInstance()
	{
		$mov =  App::make('LangLeap\Videos\Movie');
		$mov->name = '';
		$mov->save();
		return $mov;
	}
	protected function getVideoInstance()
	{
		$video =  App::make('LangLeap\Videos\Video');
		$video->path = '';
		return $video;
	}
	
	protected function getScriptInstance()
	{
		return App::make('LangLeap\Words\Script');
	}	

}
