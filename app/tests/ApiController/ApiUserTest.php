<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class ApiUserControllerTest extends TestCase {

	protected function createUserData()
	{
		return $userData = [
			'username'   => 'testUser123',
			'email'      =>'test@tester.com',
			'first_name' => 'John',
			'last_name'  =>'Doe',
			'password'   => 'password123'
		];
	}

	public function testCreatingANewUser()
	{
		$userData = $this->createUserData();

		$response = $this->action('POST', 'ApiUserController@store', [], $userData);

		// 201 Created response.
		$this->assertResponseStatus(201);
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);

		// Verify the created user's details.
		$user = User::where('username', $userData['username'])->first();

		$this->assertNotNull($user);
		$this->assertSame($userData['email'], $user->email);
		$this->assertSame($userData['first_name'], $user->first_name);
		$this->assertSame($userData['last_name'], $user->last_name);
		$this->assertTrue(Hash::check($userData['password'], $user->password));
	}

	public function testFailsWhenCreatingADuplicateUser()
	{
		$userData = $this->createUserData();

		// Create the user first
		$response = $this->action('POST', 'ApiUserController@store', [], $userData);

		// Attempt to create the user again
		$response = $this->action('POST', 'ApiUserController@store', [], $userData);

		// Should return a client error code.
		$this->assertResponseStatus(400);
	}

	public function testFailsWhenCreatingAUserWhileAuthenticated()
	{
		$userData = $this->createUserData();

		// Authenticate as a user.
		$this->be(new User());

		$response = $this->action('POST', 'ApiUserController@store', [], $userData);

		// Should return a 403 Forbidden response.
		$this->assertResponseStatus(403);
	}

	public function testShowTheAuthenticatedUser()
	{
		// Seed and get the user.
		$this->seed();
		$user = User::first();

		// Be authenticated
		$this->be($user);

		// Fetch the current user
		$response = $this->action('GET', 'ApiUserController@show', $user->id);

		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
	}

	public function testFailsWhenAttemptingToShowAnotherUser()
	{
		// Authenticate as a mock user
		$this->be(new User);

		// Fetch another user
		$response = $this->action('GET', 'ApiUserController@show', 10);

		$this->assertResponseStatus(401);
	}

	public function testUpdateFieldsOnTheAuthenticatedUser()
	{
		// Seed and fetch the user.
		$this->seed();
		$user = User::first();

		// Be authenticated
		$this->be($user);

		// Make some changes
		$user->username = 'testuser';

		$response = $this->action('PATCH', 'ApiUserController@update', $user->id, $user->toArray());

		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);

		// Verify the changes from the database
		$updatedUser = User::find($user->id);
		$this->assertSame($user->username, $updatedUser->username);
		$this->assertSame($user->email, $updatedUser->email);
		$this->assertSame($user->first_name, $updatedUser->first_name);
		$this->assertSame($user->last_name, $updatedUser->last_name);
		$this->assertSame($user->password, $updatedUser->password);
	}

	public function testUpdateNothingOnTheAuthenticatedUser()
	{
		// Seed and fetch the user.
		$this->seed();
		$user = User::first();

		// Be authenticated
		$this->be($user);

		// Send an empty array
		$response = $this->action('PATCH', 'ApiUserController@update', $user->id, []);

		$this->assertResponseOk();
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);

		// Verify that there are no changes, from the database
		$updatedUser = User::find($user->id);
		$this->assertSame($user->username, $updatedUser->username);
		$this->assertSame($user->email, $updatedUser->email);
		$this->assertSame($user->first_name, $updatedUser->first_name);
		$this->assertSame($user->last_name, $updatedUser->last_name);
		$this->assertSame($user->password, $updatedUser->password);
	}

	public function testFailsWhenTryingToUpdateAnotherUser()
	{
		// Seed and fetch the user.
		$this->seed();
		$user = User::first();

		// Be authenticated as another user
		$this->be(new User);

		// Make some changes
		$userData = $user->toArray();
		$userData['username'] = 'updatetest';

		$response = $this->action('PATCH', 'ApiUserController@update', $user->id, $userData);

		$this->assertResponseStatus(401);
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
