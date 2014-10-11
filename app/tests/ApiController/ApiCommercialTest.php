<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Commercial;


/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ApiCommercialTest extends TestCase {

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiCommercialController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiCommercialController@show', [1]);

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
		$response = $this->action('GET', 'ApiCommercialController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiCommercialController@store',
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

		$commercial = Commercial::all()->first();
		$response = $this->action(
			'PUT',
			'ApiCommercialController@update',
			[$commercial->id],
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
			'ApiCommercialController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$commercial = Commercial::all()->first();
		$response = $this->action(
			'PUT',
			'ApiCommercialController@update',
			[$commercial->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(500);
	}

	public function testDestroy()
	{
		$this->seed();
		$commercial = Commercial::all()->first();
		$id = $commercial->id;
		$response = $this->action(
			'DELETE',
			'ApiCommercialController@destroy',
			[$commercial->id]
		);

		$this->assertResponseOk();

		$commercial = Commercial::find($id);
		$this->assertNUll($commercial);

	}
	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiCommercialController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}
}
