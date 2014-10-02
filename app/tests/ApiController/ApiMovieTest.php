<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Movie;

class ApiMovieTest extends TestCase {

	/**
	 * Test GET all movies.
	 *
	 * @return void
	 */
	public function testShowApi()
	{
		$response = $this->action('GET', 'ApiMovieController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}
