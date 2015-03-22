<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Commercial;
use LangLeap\Levels\Level;
use Mockery as m;


/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ApiCommercialTest extends TestCase {

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

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiCommercialController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testIndexAsAdmin()
	{
		$this->seed();
		$this->be($this->getUserInstance(true));

		$response = $this->action('GET', 'ApiCommercialController@index');

		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$level = Level::create(['code' => 'te', 'description' => 'test']);
		$commercial = Commercial::create(['name' => 'Doritos', 'level_id' => $level->id, 'is_published' => 1]);

		$response = $this->action('GET', 'ApiCommercialController@show', [$commercial->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('videos', $data);
		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals($commercial->id, $data->id);
	}

	public function testShowAsAdmin()
	{
		$this->be($this->getUserInstance(true));

		$level = Level::create(['code' => 'te', 'description' => 'test']);

		// Create unpublished commercial
		$commercial = Commercial::create(['name' => 'Doritos', 'level_id' => $level->id, 'is_published' => 0]);

		$response = $this->action('GET', 'ApiCommercialController@show', [$commercial->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('videos', $data);
		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals($commercial->id, $data->id);
	}

	public function testShowWithInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiCommercialController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$this->seed();

		$response = $this->action(
			'POST',
			'ApiCommercialController@store',
			[],
			['name' => 'Test', 'level_id' => 1]
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$commercial = Commercial::all()->first();
		$response = $this->action(
			'PUT',
			'ApiCommercialController@update',
			[$commercial->id],
			['name' => 'Test']
		);

		$this->assertResponseOk();
		
		$data = $response->getData();

		$this->assertEquals('Test', $data->data->name);
	}

	public function testUpdateWithInvalidID()
	{
		$response = $this->action(
			'PUT',
			'ApiCommercialController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$commercial = Commercial::all()->first();
		$response = $this->action(
			'PUT',
			'ApiCommercialController@update',
			[$commercial->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(500);
	}

	public function testDestroy()
	{
		$this->seed();
		$commercial = Commercial::all()->first();
		$id = $commercial->id;
		$response = $this->action(
			'DELETE',
			'ApiCommercialController@destroy',
			[$commercial->id]
		);

		$this->assertResponseOk();

		$commercial = Commercial::find($id);
		$this->assertNUll($commercial);

	}
	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiCommercialController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}
}
