<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;


class ApiDictionaryTest extends TestCase 
{

	public function testWordDefinition()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'dog', 'video_id' => '1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('definition', $data);
	}

	public function testWordDefinitionNotFound()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'abcdef', 'video_id' => '1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);

		$data = $response->getData()->data;

		$this->assertSame('Definition not found.', $data);
	}

	public function testVideoIdInvalid()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@index', [], ['word' => 'dog', 'video_id' => '-1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}
}
