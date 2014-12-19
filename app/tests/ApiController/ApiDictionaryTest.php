<?php 

use LangLeap\TestCase;
use LangLeap\Words\Definition;


class ApiDictionaryTest extends TestCase 
{

	public function testWordDefinition()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@show', [], ['word' => 'Dog', 'video_id' => '1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('definition', $data);
	}

	public function testWordDefinitionInvalid()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@show', [], ['word' => '{', 'videoId' => '1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testVideoIdInvalid()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiDictionaryController@show', [], ['word' => 'Dog', 'videoId' => '-1']);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}
}
