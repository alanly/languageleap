<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use LangLeap\Core\Language;
use App;

class EpisodeTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testSeasonRelation()
	{
		$show = $this->getShowInstance();	

		$season = $this->getSeasonInstance();	
		$season->show_id = $show->id;
		$season->number = 1;
		$season->is_published = 1;
		$season->save();
		
		$episode = $this->getEpisodeInstance();
		$episode->season_id = $season->id;
		$episode->number = 1;
		$episode->level_id = 1;
		$episode->name = 'test';
		$episode->is_published = 1;
		$episode->save();

		$this->assertCount(1, $episode->season()->get());			
	}

	public function testVideoRelation()
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
		$episode->level_id = 1;
		$episode->name = 'test';
		$episode->save();

		$video = $this->getVideoInstance();
		$video->path='/path/to/somewhere';
		$video->viewable_id = $episode->id;
		$video->viewable_type = 'LangLeap\Videos\Episode';
		$video->language_id = $this->getLanguageInstance()->id;
		$video->save();

		$script = $this->getScriptInstance();
		$script->video_id = $video->id;
		$script->save();	
				
		$this->assertCount(1, $episode->videos()->get());
	}

	public function testMassAssigningAttributesOnInstanceCreation()
	{
		$a = [
			'name'         => 'Test',
			'description'  => 'Test Model',
			'level_id'     => 1,
			'season_id'    => 0,
			'number'       => 0,
			'is_published' => 1
		];

		$i = Episode::create($a);
		$i = Episode::find($i->id);

		$this->assertSame($a['name'], $i->name);
		$this->assertSame($a['description'], $i->description);
		$this->assertEquals($a['level_id'], $i->level_id);
		$this->assertEquals($a['season_id'], $i->season_id);
		$this->assertEquals($a['number'], $i->number);
	}

	protected function getShowInstance()
	{
		$show = App::make('LangLeap\Videos\Show');
		$show->name = 'test';
		$show->image_path='test';
		$show->description='test';
		$show->is_published = 1;
		$show->save();
		return $show;
	}

	protected function getSeasonInstance()
	{
		return App::make('LangLeap\Videos\Season');
	}

	protected function getEpisodeInstance()
	{
		return App::make('LangLeap\Videos\Episode');
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

	protected function getLanguageInstance()
	{
		$lang = App::make('LangLeap\Core\Language');
		$lang->code = 'en';
		$lang->description = 'English';
		$lang->save();

		return $lang;
	}

}
