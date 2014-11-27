<?php

use LangLeap\TestCase;

use LangLeap\Accounts\User;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiUserControllerTest extends TestCase {

	public function testIndex()
	{
		// Seed data for testing
		$this->seed();

		// Get the user with id = 1
		$response = $this->action(
			'GET',
			'ApiUserController@index'
		);

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiUserController@store',
			[],
			['username' => 'testUser123',
			'email'=>'test@tester.com',
			'first_name' => 'John',
			'last_name'=>'Doe',
			'password' => 'password123']
		);

		// Test for success response
		$this->assertResponseStatus(201);
	}

	public function testShow()
	{
		$this->seed();

		$response = $this->action('GET', 'ApiUserController@show', 1);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}

	public function testUpdate()
	{
		$this->seed();

		// Update a couple of fields of user with id = 1
		$response = $this->action(
			'PATCH',
			'ApiUserController@show',
			1,
			['first_name' => 'Johnny',
			'last_name' => 'Depp']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertEquals('Johnny', $data->first_name);
		$this->assertEquals('Depp', $data->last_name);

		// Get user with id = 1
		$response = $this->action(
			'GET',
			'ApiUserController@show',
			1
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertEquals('Johnny', $data->first_name);
		$this->assertEquals('Depp', $data->last_name);
	}

	public function testDestroy()
	{
		$this->seed();

		// Delete user with id = 1
		$response = $this->action(
			'DELETE',
			'ApiUserController@show',
			1
		);

		$this->assertResponseStatus(204);

		// Get user with id = 1
		$response = $this->action(
			'GET',
			'ApiUserController@show',
			1
		);

		$this->assertResponseStatus(404);
	}
	
}
