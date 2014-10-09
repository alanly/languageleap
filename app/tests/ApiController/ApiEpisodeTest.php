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

		$this->assertEquals(1, $data->show->id);
		$this->assertEquals(1, $data->season->id);
		$this->assertCount(1, $data->episodes);
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
		$this->assertEquals($sesaon->id, $data->episode->season_id);
	}
	
}
