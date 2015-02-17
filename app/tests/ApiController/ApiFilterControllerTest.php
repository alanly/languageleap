<?php

use LangLeap\TestCase;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Show;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiFilterControllerTest extends TestCase {

	
	private function getFilteredDataSuccess($input, $type)
	{
		$response = $this->action(
			'GET',
			'ApiFilterController@index',
			$input
		);

		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertCount(1, $data);
		$this->assertEquals($type->id, $data[0]->id);
	}

	private function getFilteredDataFail($input, $type)
	{
		$response = $this->action(
			'GET',
			'ApiFilterController@index',
			$input
		);

		$this->assertResponseStatus(400);
	}

	public function testGetFilteredMoviesSuccess()
	{
		$this->seed();

		$movie = Movie::first();

		$query = [
			'type' => 'movie',
			'take' => 1,
			'skip' => 0,
			'name' => $movie->name,
			'level' => $movie->level->description,
		];

		$this->getFilteredDataSuccess($query, $movie);
	}

	public function testGetFilteredCommercialsSuccess()
	{
		$this->seed();

		$commercial = Commercial::first();

		$query = [
			'type' => 'commercial',
			'take' => 1,
			'skip' => 0,
			'name' => $commercial->name,
			'level' => $commercial->level->description,
		];

		$this->getFilteredDataSuccess($query, $commercial);
	}

	public function testGetFilteredShowsSuccess()
	{
		$this->seed();

		$show = Show::first();

		$query = [
			'type' => 'show',
			'take' => 1,
			'skip' => 0,
			'name' => $show->name,
		];

		$this->getFilteredDataSuccess($query, $show);
	}

	public function testGetFilteredContentFailOnMissingParameter()
	{
		$this->seed();

		$movie = Movie::first();

		$query = [
			'take' => 1,
			'skip' => 0,
			'name' => $movie->name,
			'level' => $movie->level->description,
		];

		$this->getFilteredDataFail($query, $movie);
	}

	public function testGetFilteredContentFailOnMaximumTakeExceeded()
	{
		$this->seed();

		$movie = Movie::first();

		$query = [
			'type' => 'movie',
			'take' => Config::get('filtering.max_take') + 1,
			'skip' => 0,
			'name' => $movie->name,
			'level' => $movie->level->description,
		];

		$this->getFilteredDataFail($query, $movie);
	}

	public function testGetFilteredContentFailOnInvalidSkip()
	{
		$this->seed();

		$movie = Movie::first();

		$query = [
			'type' => 'movie',
			'take' => 1,
			'skip' => 'invalidskip',
			'name' => $movie->name,
			'level' => $movie->level->description,
		];

		$this->getFilteredDataFail($query, $movie);
	}
	
}
