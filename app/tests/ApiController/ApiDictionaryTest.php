<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;


class ApiDictionaryTest extends TestCase 
{

	public function testWordDefinition()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@show', ['Dog']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('definition', $data);
	}

	public function testWordDefinitionInvalid()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@show', ['}']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}
}
