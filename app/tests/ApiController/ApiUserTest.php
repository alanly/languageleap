<?php

use LangLeap\TestCase;

use LangLeap\Accounts\User;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class ApiUserControllerTest extends TestCase {

	public function testStore()
	{
		$userData = [
			'username' => 'testUser123',
			'email'=>'test@tester.com',
			'first_name' => 'John',
			'last_name'=>'Doe',
			'password' => 'password123'
		];

		// Create a new user
		$response = $this->action(
			'POST',
			'ApiUserController@store',
			[],
			$userData
		);

		// Test for successful creation of user response
		$this->assertResponseStatus(201);

		// Attempt to create a new user that already exists
		// Note: This should be sufficient to partially test the registration validation.
		$response = $this->action(
			'POST',
			'ApiUserController@store',
			[],
			$userData
		);

		// Test for the unsuccessful creation of a user
		$this->assertResponseStatus(400);

		$user = new User($userData);

		// Set the currently authenticated user
		$this->be($user);

		// Attempt to create a new user while already being logged in
		$response = $this->action(
			'POST',
			'ApiUserController@store',
			[],
			$userData
		);

		// Test for the unsuccessful creation of a user
		$this->assertResponseStatus(401);
	}

	public function testShow()
	{
		$this->seed();

		$user = User::first();
		
		// Set the currently authenticated user
		$this->be($user);

		$response = $this->action('GET', 'ApiUserController@show', $user->id);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		// Try to get a user that isn't the currently authenticated user
		$response = $this->action('GET', 'ApiUserController@show', $user->id + 1);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(401);

	}

	public function testUpdate()
	{
		$this->seed();

		$user = User::first();
		
		// Set the currently authenticated user
		$this->be($user);
		$user->first_name = 'Johnny';
		$user->last_name = 'Depp';

		$userDataArray = $user->toArray();
		$userDataArray["password"] = "testerpassword";

		//unset($userDataArray['id']);

		// Update a couple of fields of the user
		$response = $this->action(
			'PATCH',
			'ApiUserController@update',
			$user->id,
			$userDataArray
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertEquals('Johnny', $data->first_name);
		$this->assertEquals('Depp', $data->last_name);

		// Get user
		$response = $this->action(
			'GET',
			'ApiUserController@show',
			$user->id
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

		$user = User::first();
		
		// Set the currently authenticated user
		$this->be($user);

		// Delete user
		$response = $this->action(
			'DELETE',
			'ApiUserController@destroy',
			$user->id
		);

		// Verify successful deletion
		$this->assertResponseStatus(204);

		// Get user with id = 1
		$response = $this->action(
			'GET',
			'ApiUserController@show',
			$user->id
		);

		// User should
		$this->assertResponseStatus(404);
	}
	
}
