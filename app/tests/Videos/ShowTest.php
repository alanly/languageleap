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
		$show->name = 'TestShow';
		$show->description = 'Test';
		$show->image_path = 'test';
		$show->save();

		
		$season = $this->getSeasonInstance();	
		$season->show_id = $show->id;
		$season->season_number = 1;
		$season->save();
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
