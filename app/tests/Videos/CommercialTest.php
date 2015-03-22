<?php namespace LangLeap\Videos;

use LangLeap\TestCase;
use LangLeap\Core\Language;
use App;

class CommercialTest extends TestCase {

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

	public function testMassAssigningAttributesOnInstanceCreation()
	{
		$a = [
			'name'        => 'Test',
			'description' => 'Test Commercial',
			'level_id'    => 1,
		];

		$i = new Commercial($a);
		$i->save();
		$i = Commercial::find($i->id);

		$this->assertSame($a['name'], $i->name);
		$this->assertSame($a['description'], $i->description);
		$this->assertEquals($a['level_id'], $i->level_id);
	}

	public function testFilterBySuccessWithNoSkip()
	{
		$this->seed();

		$commercial = Commercial::where('is_published', 1)->first();

		$input = [
			'name' => $commercial->name,
		];

		$res = Commercial::filterBy($input, 1);

		$this->assertCount(1, $res);
		$this->assertSame($commercial->name, $res[0]->name);
	}

	public function testFilterBySuccessWithSkip()
	{
		$this->seed();

		// Get the first commercial along with all the other commercials that
		// have the same level id
		$commercial = Commercial::where('is_published', 1)->first();
		$commercials = Commercial::where('level_id', '=', $commercial->level_id)
		->where('is_published', 1)->get();

		$count = count($commercials);
		$skip = (int)($count / 2);

		// If we 'skip' by an amount and we 'take' more than the remaining,
		// then we should get whatever is remaining.
		$remaining = $count - $skip;
		$take = $remaining + 1;

		$input = [
			'level' => $commercial->level->description,
		];

		$res = Commercial::filterBy($input, $take, $skip);

		$this->assertCount($remaining, $res);
	}

	public function testFilterBySuccessWithIrrelevantQueryData()
	{
		$this->seed();

		$commercial = Commercial::where('is_published', 1)->first();

		$input = [
			'name' => $commercial->name,
			'irrelevant' => 'data',
		];

		$res = Commercial::filterBy($input, 1, 0);

		$this->assertCount(1, $res);
		$this->assertSame($commercial->name, $res[0]->name);
	}

	public function testFilterBySuccessWithLevelSpecified()
	{
		$this->seed();

		$commercial = Commercial::where('is_published', 1)->first();

		$input = [
			'level' => $commercial->level->description,
		];

		$res = Commercial::filterBy($input, 1, 0);

		$this->assertCount(1, $res);
	}

	public function testFilterBySuccessWithTakeExtra()
	{
		$this->seed();

		$commercial = Commercial::where('is_published', 1)->first();

		$input = [
			'level' => $commercial->level->description,
		];

		$res = Commercial::filterBy($input, 3, 0);

		$this->assertCount(3, $res);
	}

	protected function getCommercialInstance()
	{
		$comm =  App::make('LangLeap\Videos\Commercial');
		$comm->name = 'Test Commercial';
		$comm->level_id = 1;
		$comm->save();
		return $comm;
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
