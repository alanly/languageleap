<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;


class ApiDictionaryTest extends TestCase {

	public function testDefinition()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDefinitionController@show', ['Dog']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('definition', $data);
	}

	public function testDefinitionInvalidWord()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDefinitionController@show', ['}']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}
}
