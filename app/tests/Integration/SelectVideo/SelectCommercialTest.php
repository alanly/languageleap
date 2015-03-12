<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;

class SelectCommercialTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	//1. Go to the Commercials panel in the main page
	//2. Do some filtering
	//3. Select one of the commercial
	//4. Request a video from the commercial
	public function testSelectMovie()
	{
		$this->getCommercials();
		$filteredCommercial = $this->getFilteredCommercial();
		$commercial = $this->getCommercial($filteredCommercial->id);
		$this->getVideo($commercial->videos[0]->id);
	}

	private function getCommercials()
	{
		$response = $this->action('GET', 'ApiCommercialController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	private function getFilteredCommercial()
	{
		$commercial = Commercial::first();

		$query = [
			'type' => 'commercial',
			'take' => 1,
			'skip' => 0,
			'name' => $commercial->name,
			'level' => $commercial->level->description,
		];

		return $this->getFilteredDataSuccess($query, $commercial);
	}

	private function getCommercial($id)
	{
		$response = $this->action('GET', 'ApiCommercialController@show', [$id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('videos', $data);
		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals($id, $data->id);

		return $data;
	}

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

		return $data[0];
	}

	private function getVideo($id)
	{
		$response = $this->action(
			'get',
			'ApiVideoController@show',
			[$id]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;
		$this->assertObjectHasAttribute('video', $data);
	}
	
}
