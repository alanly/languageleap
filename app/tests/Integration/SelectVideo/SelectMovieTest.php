<?php

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\Videos\Movie;

class SelectMovieIntegrationTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
	}

	//1. Go to the Movies panel in the main page
	//2. Do some filtering
	//3. Select one of the movies
	//4. Request a video from the movie
	public function testSelectMovie()
	{
		$this->getMovies();
		$filteredMovie = $this->getFilteredMovie();
		$movie = $this->getMovie($filteredMovie->id);
		$this->getVideo($movie->videos[0]->id);
	}

	private function getMovies()
	{
		$response = $this->action('GET', 'ApiMovieController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	private function getFilteredMovie()
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

		return $this->getFilteredDataSuccess($query, $movie);
	}

	private function getMovie($id)
	{
		$response = $this->action('GET', 'ApiMovieController@show', [$id]);

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
