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
		$season->number = 1;
		$season->save();
		$this->assertCount(1, $show->seasons()->get());			
	}

	public function testFilterBySuccessWithNoSkip()
	{
		$this->seed();

		$show = Show::first();

		$input = [
			'name' => $show->name,
		];

		$res = Show::filterBy($input, 1);

		$this->assertCount(1, $res);
		$this->assertSame($show->id, $res[0]->id);
	}

	public function testFilterBySuccessWithSkip()
	{
		$this->seed();

		$show = Show::first();

		// There should be more than one show beginning
		// with the same letter
		$letter = substr($show->name, 0, 1);

		$input = [
			'name' => $letter,
		];

		$res = Show::filterBy($input, 1, 1);

		$match = Show::find($res[0]->id);
		$matchFirstLetter = substr($match->name, 0, 1);

		$this->assertCount(1, $res);
		$this->assertSame($letter, $matchFirstLetter);
	}

	public function testFilterBySuccessWithIrrelevantQueryData()
	{
		$this->seed();

		$show = Show::first();

		$input = [
			'name' => $show->name,
			'irrelevant' => 'data',
		];

		$res = Show::filterBy($input, 1, 0);

		$this->assertCount(1, $res);
		$this->assertSame($show->id, $res[0]->id);
	}

	public function testFilterBySuccessWithTakeExtra()
	{
		$this->seed();

		$show = Show::first();

		// There should be more than one show beginning
		// with the same letter
		$input = [
			'name' => substr($show->name, 0, 1),
		];

		$res = Show::filterBy($input, 2, 0);

		$this->assertCount(2, $res);
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
