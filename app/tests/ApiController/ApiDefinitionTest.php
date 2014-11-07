<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;


class ApiDefinitionTest extends TestCase {

	public function testIndex()
	{
		$response = $this->action('GET', 'ApiDefinitionController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testDefinition()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDefinitionController@show', [1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('definition', $data);
		$this->assertObjectHasAttribute('full_definition', $data);
		$this->assertEquals(1, $data->id);
	}

	public function testDefinitionInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDefinitionController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiDefinitionController@store',
			['word' => 'Test word', 
			'definition' => 'Test definition',
			'full_definition' => 'Test full definition']
		);

		$this->assertResponseStatus(201);
		$data = $response->getData();
		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$def = Definition::all()->first();
		$response = $this->action(
			'PUT',
			'ApiDefinitionController@update',
			[$def->id],
			['definition' => 'New test definition', 'full_definition' => 'New test full definition']
		);

		$this->assertResponseOk();
		$data = $response->getData();
		$this->assertEquals('New test definition', $data->data->definition);
	}

	public function testUpdateInvalidID()
	{
		$response = $this->action(
			'PUT',
			'ApiDefinitionController@update',
			[-1],
			['definition' => 'New test definition', 'full_definition' => 'New test full definition']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}
}
