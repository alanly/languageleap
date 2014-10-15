<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Show;


/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class FlashcardTest extends TestCase {

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiShowController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiShowController@show', [1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals(1, $data->id);
	}

	public function testShowWithInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiShowController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiShowController@store',
			[],
			['name' => 'Test', 'description' => 'Test']
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$show = Show::all()->first();
		$response = $this->action(
			'PUT',
			'ApiShowController@update',
			[$show->id],
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
			'ApiShowController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$show = Show::all()->first();
		$response = $this->action(
			'PUT',
			'ApiShowController@update',
			[$show->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(500);
	}
	public function testDestroy()
	{
		$this->seed();
		$show = Show::all()->first();
		$id = $show->id;
		$response = $this->action(
			'DELETE',
			'ApiShowController@destroy',
			[$show->id]
		);

		$this->assertResponseOk();

		$show = Show::find($id);
		$this->assertNUll($show);

	}
	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiShowController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}
}
