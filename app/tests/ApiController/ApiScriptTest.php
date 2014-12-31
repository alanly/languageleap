<?php

use LangLeap\TestCase;
use LangLeap\Words\Script;

class ApiScriptControllerTest extends TestCase {

	public function testIndex()
	{
		$this->seed();

		$response = $this->action('GET', 'ApiScriptController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testStore()
	{
		$script = Script::create(['text' => 'Test script.', 'video_id' => '1']);

		$response = $this->action(
			'POST',
			'ApiScriptController@store',
			[],
			['text' => $script->text, 'video_id' => $script->video_id]
		);

		$this->assertResponseStatus(201);
		$data = $response->getData();
		$this->assertEquals('success', $data->status);
	}

	public function testShow()
	{
		$this->seed();

		$response = $this->action('GET', 'ApiScriptController@show', [1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('text', $data);
		$this->assertObjectHasAttribute('video_id', $data);
	}

	public function testUpdate()
	{
		$this->seed();

		$response = $this->action(
			'PATCH',
			'ApiScriptController@update',
			[1],
			['text' => 'Test script update.']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('text', $data);
		$this->assertObjectHasAttribute('video_id', $data);
		$this->assertEquals('Test script update.', $data->text);
	}

	public function testDestroy()
	{
		$this->seed();

		$response = $this->action(
			'DELETE',
			'ApiScriptController@destroy',
			[1]
		);

		$this->assertResponseStatus(200);

		$response = $this->action(
			'GET',
			'ApiScriptController@show',
			[1]
		);

		// is script deleted?
		$this->assertResponseStatus(404);
	}
	
}