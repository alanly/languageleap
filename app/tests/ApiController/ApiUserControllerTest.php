<?php

use LangLeap\Accounts\User;

class ApiUserControllerTest extends TestCase {
	
	private $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->be($this->getUserInstance());
		$this->be($user);
	}
	
	public function testUpdatePasswordWithProperInputs() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'abc',
				'confirm_old_password' => 'password',
			]
		);
		
		$this->assertInstance('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
		
		$this->assertTrue(Hash::check('abc', User::find($user->id)->password));
		
		//$this->assertResponseStatus(404);
	}
	
	public function testUpdatePasswordWithDifferentOldPassword() {
		
		$response = $this->action 
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'abc',
				'confirm_old_password' => 'different',
			]
		);
		
		$this->assertInstance('Illuminate\Http\JsonResponse', $response);
		//$this->assertResponseOk();
		
		$this->assertTrue(Hash::check('abc', User::find($user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	public function testUpdatePasswordWithDifferentNewPasswordAgain() {
		
		$response = $this->action 
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'different',
				'confirm_old_password' => 'password',
			]
		);
		
		$this->assertInstance('Illuminate\Http\JsonResponse', $response);
		//$this->assertResponseOk();
		
		$this->assertTrue(Hash::check('abc', User::find($user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	public function testUpdatePasswordWithDifferentNewAgainAndOldPassword() {
		
		$response = $this->action 
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'different',
				'confirm_old_password' => 'different',
			]
		);
		
		$this->assertInstance('Illuminate\Http\JsonResponse', $response);
		//$this->assertResponseOk();
		
		$this->assertTrue(Hash::check('abc', User::find($user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	protected function getUserInstance() {
		
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = 'password';
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = false;
		$user-> save();
		
		return $user;
	}
}