<?php

use LangLeap\TestCase;

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
	
}
