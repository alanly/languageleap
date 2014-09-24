<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class ShowTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testSeasonRelation()
	{
		$show = $this->getShowInstance();	
		$season = $this->getSeasonInstance();
		
		$show->season_id = $season->id;
		$show->save();
		$this->assertCount(1, $show->seasons()->get());			
	}
	protected function getShowInstance()
	{
		return App::make('LangLeap\Videos\Show');
	}
	protected function getSeasonInstance()
	{
		return App::make('LangLeap\Videos\Season');
	}
	

}
