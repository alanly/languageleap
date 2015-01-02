<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Movie;


/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ApiMovieTest extends TestCase {

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiMovieController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiMovieController@show', [1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('videos', $data);
		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals(1, $data->id);
	}

	public function testShowWithInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiMovieController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'Test']
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$movie = Movie::all()->first();
		$response = $this->action(
			'PUT',
			'ApiMovieController@update',
			[$movie->id],
			['name' => 'Test']
		);

		$this->assertResponseOk();
		
		$data = $response->getData();

		$this->assertEquals('Test', $data->data->name);
	}

	public function testUpdateWithInvalidID()
	{
		$response = $this->action(
			'PUT',
			'ApiMovieController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$movie = Movie::all()->first();
		$response = $this->action(
			'PUT',
			'ApiMovieController@update',
			[$movie->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}

	public function testDestroy()
	{
		$this->seed();
		$movie = Movie::all()->first();
		$id = $movie->id;
		$response = $this->action(
			'DELETE',
			'ApiMovieController@destroy',
			[$movie->id]
		);

		$this->assertResponseStatus(204);

		$movie = Movie::find($id);
		$this->assertNUll($movie);

	}
	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiMovieController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}
}
