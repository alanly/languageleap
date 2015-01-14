<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use App;

class MovieTest extends TestCase {

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

	public function testMassAssigningAttributesOnInstanceCreation()
	{
		$a = [
			'name'        => 'Test',
			'description' => 'Test Model',
			'level_id'    => 1,
			'director'    => 'Mr. Director',
			'actor'       => 'Dr. Actor',
			'genre'       => 'Japanese Fusion Drama',
		];

		$i = Movie::create($a);
		$i = Movie::find($i->id);

		$this->assertSame($a['name'], $i->name);
		$this->assertSame($a['description'], $i->description);
		$this->assertEquals($a['level_id'], $i->level_id);
		$this->assertSame($a['director'], $i->director);
		$this->assertSame($a['actor'], $i->actor);
		$this->assertSame($a['genre'], $i->genre);
	}

	protected function getMovieInstance()
	{
		$mov =  App::make('LangLeap\Videos\Movie');
		$mov->name = 'Test Movie';
		$mov->level_id = 1;
		$mov->save();
		return $mov;
	}

	protected function getVideoInstance()
	{
		$video =  App::make('LangLeap\Videos\Video');
		$video->path = '/path/to/somewhere';
		$video->language_id = $this->getLanguageInstance()->id;
		return $video;
	}
	
	protected function getScriptInstance()
	{
		return App::make('LangLeap\Words\Script');
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
