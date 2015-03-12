<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Videos\Show;

class SelectShowTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	//1. Go to the Shows panel in the main page
	//2. Do some filtering
	//3. Select one of the shows
	//4. Select a season
	//5. Select an episode
	//6. Request a video from the episode
	public function testSelectShow()
	{
		$this->getShows();
		$filteredShow = $this->getFilteredShow();
		$seasons = $this->getSeasons($filteredShow->id);
		$episodes = $this->getEpisodes($filteredShow->id, $seasons[0]->id);
		$this->getVideo($episodes[0]->videos[0]->id);
	}

	private function getShows()
	{
		$response = $this->action('GET', 'ApiShowController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	private function getFilteredShow()
	{
		$show = Show::first();

		$query = [
			'type' => 'show',
			'take' => 1,
			'skip' => 0,
			'name' => $show->name,
		];

		return $this->getFilteredDataSuccess($query, $show);
	}

	private function getSeasons($id)
	{
		$response = $this->action(
			'GET',
			'ApiSeasonController@index',
			['showId' => $id]
		);

		$this->assertResponseOk();

		return $response->getData()->data->seasons;
	}

	private function getEpisodes($showId, $seasonId)
	{
		$response = $this->action(
			'GET',
			'ApiEpisodeController@index',
			[$showId, $seasonId]
		);

		$this->assertResponseOk();

		$data = $response->getData()->data;
		$episodes = Show::find($showId)->seasons()->where('id', $seasonId)->first()->episodes()->get();

		$this->assertEquals($showId, $data->show->id);
		$this->assertEquals($seasonId, $data->season->id);
		$this->assertCount($episodes->count(), $data->episodes);

		return $episodes;
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
