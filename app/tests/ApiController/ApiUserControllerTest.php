<?php

use LangLeap\TestCase;
use LangLeap\Accounts\User;

class ApiUserControllerTest extends TestCase {
	
	private $user;
	
	public function setUp() {
		
		parent::setUp();
		$this->user = $this->getUserInstance();
		$this->be($this->user);
	}
	
	//Tests for updating password
	public function testUpdatePasswordWithProperInputs() 
	{
	
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
		
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		
		$this->assertTrue(Hash::check('abc', User::find($this->user->id)->password));
		
		$this->assertResponseOk();
	}
	
	public function testUpdatePasswordWithDifferentOldPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'abc',
				'confirm_old_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertFalse(Hash::check('abc', User::find($this->user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	public function testUpdatePasswordWithDifferentNewPasswordAgain() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'different',
				'confirm_old_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertFalse(Hash::check('abc', User::find($this->user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	public function testUpdatePasswordWithDifferentNewPasswordAgainAndOldPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdatePassword',
			[],
			[
				'new_password' => 'abc',
				'new_password_again' => 'different',
				'confirm_old_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertFalse(Hash::check('abc', User::find($this->user->id)->password));
		
		$this->assertResponseStatus(400);
	}
	
	//Tests for updating user info
	public function testUpdateUserInfoWithProperInputs() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => 'Five',
				'new_email' => 'user@newemail.com',
				'language_id' => 2,
				'current_password' => 'password',
			]
		);
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}
	
	public function testUpdateUserInfoWithProperInputsAndIncorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => 'Five',
				'new_email' => 'user@newemail.com',
				'language_id' => 2,
				'current_password' => 'different',
			]
		);
			
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	/*public function testUpdateFirstNameAndLastNameWithCorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => 'Five',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}
	
	public function testUpdateFirstNameAndLastNameWithIncorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => 'Five',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateFirstNameAndEmptyLastNameWithCorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => '',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateFirstNameAndEmptyLastNameWithIncorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => 'Tom',
				'last_name' => '',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmptyFirstNameAndLastNameWithCorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => '',
				'last_name' => 'Five',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmptyFirstNameAndLastNameWithIncorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => '',
				'last_name' => 'Five',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmptyFirstNameAndEmptyLastNameWithCorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => '',
				'last_name' => '',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmptyFirstNameAndEmptyLastNameWithIncorrectPassword() {
		
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'first_name' => '',
				'last_name' => '',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmailWithProperEmailAndCorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'new_email' => 'username@newemail.com',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}
	
	public function testUpdateEmailWithProperEmailAndIncorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'new_email' => 'username@newemail.com',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmailWithImproperEmailAndCorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'new_email' => 'username.com',
				'current_password' => 'password',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateEmailWithImproperEmailAndIncorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'new_email' => 'username.com',
				'current_password' => 'different',
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateLanguageIDWithCorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'language_id' => 1,
				'current_password' => 'password'
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}
	
	public function testUpdateLanguageIDWithIncorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'language_id' => 2,
				'current_password' => 'different'
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateLanguageIDWithInvalidLanguageIDAndCorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'language_id' => 0,
				'current_password' => 'password'
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
	
	public function testUpdateLanguageIDWithInvalidLanguageIDAndIncorrectPassword() {
	
		$response = $this->action (
			'POST',
			'ApiUserController@postUpdateUserInfo',
			[],
			[
				'language_id' => 0,
				'current_password' => 'different'
			]
		);
		
		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}*/
	
	protected function getUserInstance() {
		
		$user = App::make('LangLeap\Accounts\User');
		$user->username = 'username';
		$user->email = 'username@email.com';
		$user->password = Hash::make('password');
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->language_id = 1;
		$user->is_admin = false;
		$user-> save();
		
		return $user;
	}
}