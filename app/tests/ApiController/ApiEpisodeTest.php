<?php

use LangLeap\TestCase;
use LangLeap\Videos\Show;
use LangLeap\Levels\Level;
use LangLeap\Videos\Episode;


/**
 * @author Alan Ly <hello@alan.ly>
 */
class ApiEpisodeControllerTest extends TestCase {

	public function testIndex()
	{
		// Seed test data
		$this->seed();

		$show = Show::first();
		$season = $show->seasons()->first();

		// Get Show #1, Season #1
		$response = $this->action(
			'GET',
			'ApiEpisodeController@index',
			[$show->id, $season->id]
		);

		$this->assertResponseOk();

		$data = $response->getData()->data;
		$episodes = Show::find($show->id)->seasons()->where('id', $season->id)->first()->episodes()->get();

		$this->assertEquals($show->id, $data->show->id);
		$this->assertEquals($season->id, $data->season->id);
		$this->assertCount($episodes->count(), $data->episodes);
	}

	public function testStore()
	{
		// Seed test data
		$this->seed();

		$show = Show::create(['name' => 'test show', 'description' => 'test show description', 'is_published' => 1]);
		$season = $show->seasons()->create(['number' => 1, 'is_published' => 1]);
		$level = Level::first();
		$response = $this->action(
			'POST',
			'ApiEpisodeController@store',
			[$show->id, $season->id],
			['number' => 1, 'name' => 'Test Episode', 'level_id' => $level->id, 'is_published' => 1]
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);

		$data = $data->data;

		$this->assertEquals($show->id, $data->show->id);
		$this->assertEquals($season->id, $data->season->id);
		$this->assertEquals($season->id, $data->episode->season_id);
	}

	public function testShow()
	{
		$this->seed();

		$show = Show::first();
		$season = $show->seasons()->first();
		$episode = $season->episodes()->first();

		// Retrieve Show 1 > Season 1 > Episode 1
		$response = $this->action('GET', 'ApiEpisodeController@show', [$show->id, $season->id, $episode->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('show', $data);
		$this->assertObjectHasAttribute('season', $data);
		$this->assertObjectHasAttribute('episode', $data);
		$this->assertObjectHasAttribute('videos', $data);

		$this->assertEquals($episode->id, $data->episode->id);
	}

	public function testShowEpisode()
	{
		$this->seed();

		$episode = Episode::first();

		// Retrieve Episode 1
		$response = $this->action('GET', 'ApiEpisodeController@showEpisode', [$episode->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('episode', $data);
		$this->assertObjectHasAttribute('videos', $data);

		$this->assertEquals($episode->id, $data->episode->id);
	}

	public function testUpdate()
	{
		$this->seed();

		$show = Show::first();
		$season = $show->seasons()->first();
		$episode = $season->episodes()->first();

		// Update Show 1 > Season 1 > Episode 1
		$response = $this->action(
			'PATCH',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id],
			['name' => 'test update episode']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('show', $data);
		$this->assertObjectHasAttribute('season', $data);
		$this->assertObjectHasAttribute('episode', $data);

		$this->assertEquals('test update episode', $data->episode->name);

		// Get Show 1 > Season 1 > Episode 1
		$response = $this->action(
			'GET',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertEquals('test update episode', $data->episode->name);
	}

	public function testDestroy()
	{
		$this->seed();

		$show = Show::first();
		$season = $show->seasons()->first();
		$episode = $season->episodes()->first();

		// Get Show 1 > Season 1 > Episode 1; make sure it exists before we
		// try to delete it.
		$response = $this->action(
			'GET',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseOk();

		// Delete Show 1 > Season 1 > Episode 1
		$response = $this->action(
			'DELETE',
			'ApiEpisodeController@destroy',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseStatus(204);

		// Get Show 1 > Season 1 > Episode 1
		$response = $this->action(
			'GET',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseStatus(404);
	}

	public function testDestroyEpisodeThatIsNotTheFirst()
	{
		$this->seed();

		$show = Show::first();
		$season = $show->seasons()->first();
		$episode = $season->episodes()->get()[1];

		// Get Show 1 > Season 1 > Episode 2; make sure it exists before we
		// try to delete it.
		$response = $this->action(
			'GET',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseOk();

		// Delete Show 1 > Season 1 > Episode 2
		$response = $this->action(
			'DELETE',
			'ApiEpisodeController@destroy',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseStatus(204);

		// Get Show 1 > Season 1 > Episode 2
		$response = $this->action(
			'GET',
			'ApiEpisodeController@show',
			[$show->id, $season->id, $episode->id]
		);

		$this->assertResponseStatus(404);
	}
	
}
