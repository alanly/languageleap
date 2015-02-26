<?php 

use LangLeap\TestCase;
use LangLeap\Accounts\User;

/**
* @author Thomas Rahn <Thomas@rahn.ca>
*/
class ApiAdminUserControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}

	public function testSetInactive()
	{
		$user = User::first();

		$response = $this->action(
			'POST', 
			'ApiAdminUserController@postActive', 
			[],
			[
				'user_id' => $user->id
			]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

	}

	public function testSetInactiveWithNoUser()
	{
		$response = $this->action(
			'POST', 
			'ApiAdminUserController@postActive', 
			[], []
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

}
