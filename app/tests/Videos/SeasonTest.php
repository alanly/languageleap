<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class SeasonTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testShowRelation()
	{
		$show = $this->getShowInstance();	
		$show->name = 'TestShow';
		$show->description = 'Test';
		$show->image_path = 'test';
		$show->save();

		
		$season = $this->getSeasonInstance();	
		$season->show_id = $show->id;
		$season->number = 1;
		$season->save();
		$this->assertCount(1, $season->show()->get());			
	}

	public function testEpisodeRelation()
	{
		$show = $this->getShowInstance();
		$show->name = 'TestShow';
		$show->description = 'Test';
		$show->image_path = 'test';
		$show->save();


		$season = $this->getSeasonInstance();
		$season->show_id = $show->id;
		$season->number = 1;
		$season->save();

		$episode = $this->getEpisodeInstance();
		$episode->season_id = $season->id;
		$episode->number = 1;
		$episode->name = 'test';
		$episode->save();
	
		$this->assertCount(1, $season->episodes()->get());


	}	
	protected function getShowInstance()
	{
		return App::make('LangLeap\Videos\Show');
	}
	protected function getSeasonInstance()
	{
		return App::make('LangLeap\Videos\Season');
	}
	protected function getEpisodeInstance()
	{
		return App::make('LangLeap\Videos\Episode');
	}
	

}
