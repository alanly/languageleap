<?php

use LangLeap\TestCase;
use LangLeap\Videos\Show;
use LangLeap\Videos\Season;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ApiSeasonControllerTest extends TestCase {

	protected function getUserInstance($admin = false) {
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = Hash::make('password');
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = $admin;

		return m::mock($user);
	}

	public function testForInvalidWildcards()
	{
		// Create a show and season
		$show = $this->createShow();
		$season = $this->createSeason($show);

		// Invalid show on Index
		$response = $this->action(
			'GET',
			'ApiSeasonController@index',
			[555]
		);
		$this->assertResponseStatus(404);

		// Invalid show on Store
		$response = $this->action(
			'POST',
			'ApiSeasonController@store',
			[555],
			['number' => 1, 'description' => 'Test']
		);
		$this->assertResponseStatus(404);

		// Invalid show on Show
		$response = $this->action(
			'GET',
			'ApiSeasonController@show',
			[555, 555]
		);
		$this->assertResponseStatus(404);

		// Invalid season on Show
		$response = $this->action(
			'GET',
			'ApiSeasonController@show',
			[$show->id, 555]
		);
		$this->assertResponseStatus(404);

		// Invalid show on Update
		$response = $this->action(
			'PATCH',
			'ApiSeasonController@update',
			[555, 555],
			[]
		);
		$this->assertResponseStatus(404);

		// Invalid season on Update
		$response = $this->action(
			'PATCH',
			'ApiSeasonController@update',
			[$show->id, 555],
			[]
		);
		$this->assertResponseStatus(404);

		// Invalid show on Destroy
		$response = $this->action(
			'DELETE',
			'ApiSeasonController@destroy',
			[555, 555]
		);
		$this->assertResponseStatus(404);

		// Invalid season on Destroy
		$response = $this->action(
			'DELETE',
			'ApiSeasonController@destroy',
			[$show->id, 555]
		);
		$this->assertResponseStatus(404);
	}

	public function testIndexForShow()
	{
		$show = $this->createShow();

		$response = $this->action(
			'GET',
			'ApiSeasonController@index',
			['showId' => $show->id]
		);

		$this->assertResponseOk();
	}

	public function testIndexForShowAsAdmin()
	{
		$this->be($this->getUserInstance(true));

		$show = $this->createShow(0);

		$response = $this->action(
			'GET',
			'ApiSeasonController@index',
			['showId' => $show->id]
		);

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$show = $this->createShow();

		$response = $this->action(
			'POST',
			'ApiSeasonController@store',
			['showId' => $show->id],
			['number' => 1, 'description' => 'Test']
		);

		$this->assertResponseStatus(201);

		$response = $response->getData();

		$this->assertEquals('success', $response->status);

		$season = $response->data->season;

		$this->assertEquals(1, $season->number);
		$this->assertEquals($show->id, $season->show_id);
		$this->assertEquals('Test', $season->description);
	}

	public function testShowForSeason()
	{
		$show = $this->createShow();
		$season = $this->createSeason($show);

		$response = $this->action(
			'GET',
			'ApiSeasonController@show',
			['showId' => $show->id, 'seasonId' => $season->id]
		);

		$this->assertResponseOk();
	}

	public function testShowForSeasonAsAdmin()
	{
		$this->be($this->getUserInstance(true));

		$show = $this->createShow(0);
		$season = $this->createSeason($show, 0);

		$response = $this->action(
			'GET',
			'ApiSeasonController@show',
			['showId' => $show->id, 'seasonId' => $season->id]
		);

		$this->assertResponseOk();
	}

	public function testUpdate()
	{
		$show = $this->createShow();
		$season = $this->createSeason($show);

		$response = $this->action(
			'PATCH',
			'ApiSeasonController@update',
			['showId' => $show->id, 'seasonId' => $season->id],
			['number' => 500]
		);

		$this->assertResponseOk();

		$response = $response->getData();
		$this->assertEquals('success', $response->status);

		$updatedSeason = $response->data->season;
		$this->assertEquals(500, $updatedSeason->number);
	}

	public function testDestroy()
	{
		$show = $this->createShow();
		$season = $this->createSeason($show);

		$response = $this->action(
			'DELETE',
			'ApiSeasonController@destroy',
			['showId' => $show->id, 'seasonId' => $season->id]
		);

		$this->assertResponseStatus(204);

		$response = $this->action(
			'GET',
			'ApiSeasonController@index',
			['showId' => $show->id]
		);

		$seasons = $response->getData()->data->seasons;

		$this->assertCount(0, $seasons);
	}

	protected function createShow($published = 1)
	{
		return Show::create([
			'name' => 'Test Show',
			'description' => 'Test Show',
			'is_published' => $published
		]);
	}

	protected function createSeason(Show $show, $published = 1)
	{
		if (! $show->exists())
		{
			throw new Exception("Show doesn't exist.");
		}

		return Season::create([
			'show_id' => $show->id,
			'number' => 1,
			'is_published' => $published
		]);
	}
	
}
