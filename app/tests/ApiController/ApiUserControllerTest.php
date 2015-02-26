<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use Mockery as m;

class ApiUserControllerTest extends TestCase {
	
	private $user;
	
	public function setUp()
	{	
		parent::setUp();
		Route::enableFilters();
	}

	protected function getUserInstance($admin = false) {
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = Hash::make('password');
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = $admin;

		return m::mock($user);
	}

	public function testGetAllUsers()
	{
		$this->be($this->getUserInstance(true));

		$response = $this->action('GET', 'ApiUserController@getIndex');

		$this->assertResponseOk();
	}

	public function testGetAllUsersWhileNotBeingAdmin()
	{
		$this->be($this->getUserInstance(false));
		
		$response = $this->action('GET', 'ApiUserController@getIndex');

		$this->assertResponseStatus(401);
	}

	public function testOnlyUpdatingPasswordWillNotAffectOtherModelValues()
	{
		$user = $this->getUserInstance();
		$user->shouldReceive('fill')->once()->with(m::hasKey('password'));

		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'password',
				'new_password' => 'foobarsoup',
				'new_password_confirmation' => 'foobarsoup',
			]);

		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertSame($user->username, $data->username);
		$this->assertSame($user->email, $data->email);
		$this->assertSame($user->first_name, $data->first_name);
		$this->assertSame($user->last_name, $data->last_name);
		$this->assertSame($user->language_id, $data->language_id);
		$this->assertSame($user->is_admin, $data->is_admin);
	}

	public function testSendingEmptyNewPasswordValuesWillNotChangeTheUserPassword()
	{
		$user = $this->getUserInstance();
		$user->shouldReceive('fill')->with(m::on(function($data)
			{
				return ! array_key_exists('password', $data);
			}));

		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'password',
				'new_password' => '',
				'new_password_confirmation' => '',
			]);

		$this->assertResponseOk();

		$data = $response->getData()->data;

		$updatedUser = User::find($data->id);

		$this->assertTrue(Hash::check('password', $updatedUser->password));
	}

	public function testUpdatingJsonableModelAttribute()
	{
		$user = $this->getUserInstance();

		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'password',
				'first_name' => 'Shamalamadindong',
			]);

		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertSame($user->username, $data->username);
		$this->assertSame($user->email, $data->email);
		$this->assertSame($user->last_name, $data->last_name);
		$this->assertSame($user->language_id, $data->language_id);
		$this->assertSame($user->is_admin, $data->is_admin);

		$this->assertSame('Shamalamadindong', $data->first_name);
	}

	public function testAttemptingToUpdateWithInvalidPasswordFails()
	{
		$user = $this->getUserInstance();
		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'edward',
				'new_password' => 'fo',
				'new_password_confirmation' => 'foobarsoup',
			]);

		$this->assertResponseStatus(400);
	}

	public function testFailedUpdaterValidationReturnsErrorMessage()
	{
		$user = $this->getUserInstance();
		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'password',
				'new_password' => 'abc',
				'new_password_confirmation' => '123',
			]);

		$this->assertResponseStatus(400);

		$data = $response->getData()->data;

		$this->assertCount(2, $data);
	}

	public function testFailedModelValidationReturnsErrorMessage()
	{
		$user = $this->getUserInstance();
		$user->shouldReceive('save')->andReturn(false);
		$user->shouldReceive('getErrors')->andReturn('foobar');

		$this->be($user);

		$response = $this->action('PUT', 'ApiUserController@putUser', [],
			[
				'password' => 'password',
				'abc' => '123'
			]);

		$this->assertResponseStatus(400);

		$data = $response->getData()->data;

		$this->assertSame('foobar', $data);
	}

}
