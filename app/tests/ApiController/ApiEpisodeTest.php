<?php

use LangLeap\TestCase;

use LangLeap\Videos\Show;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ApiEpisodeControllerTest extends TestCase {

	public function testIndex()
	{
		// Seed test data
		$this->seed();

		// Get Show #1, Season #1
		$response = $this->action(
			'GET',
			'ApiEpisodeController@index',
			[1, 1]
		);

		$this->assertResponseOk();

		$data = $response->getData()->data;
		$episodes = Show::find(1)->seasons()->where('id', 1)->first()->episodes()->get();

		$this->assertEquals(1, $data->show->id);
		$this->assertEquals(1, $data->season->id);
		$this->assertCount($episodes->count(), $data->episodes);
	}

	public function testStore()
	{
		$show = Show::create(['name' => 'test show', 'description' => 'test show description']);
		$season = $show->seasons()->create(['number' => 1]);

		$response = $this->action(
			'POST',
			'ApiEpisodeController@store',
			[$show->id, $season->id],
			['number' => 1]
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

		// Retrieve Show 1 > Season 1 > Episode 1
		$response = $this->action('GET', 'ApiEpisodeController@show', [1, 1, 1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('show', $data);
		$this->assertObjectHasAttribute('season', $data);
		$this->assertObjectHasAttribute('episode', $data);

		$this->assertEquals(1, $data->episode->id);
	}
	
}
