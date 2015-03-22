<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Show;
use Mockery as m;


/**
*
*	@author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ApiShowTest extends TestCase {

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
	 * Test geting all published movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiShowController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testIndexAsAdmin()
	{
		$this->seed();
		$this->be($this->getUserInstance(true));

		$response = $this->action('GET', 'ApiShowController@index');

		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$show = Show::create(['name' => 'test show', 'description' => 'test show description', 'is_published' => 1]);

		$response = $this->action('GET', 'ApiShowController@show', [$show->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals($show->id, $data->id);
	}

	public function testShowAsAdmin()
	{
		$this->be($this->getUserInstance(true));

		// Create unpublished show
		$show = Show::create(['name' => 'test show 1', 'description' => 'test show description', 'is_published' => 0]);

		$response = $this->action('GET', 'ApiShowController@show', [$show->id]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals($show->id, $data->id);
	}

	public function testShowWithInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiShowController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$response = $this->action(
			'POST',
			'ApiShowController@store',
			[],
			['name' => 'Test', 'description' => 'Test']
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$show = Show::all()->first();
		$response = $this->action(
			'PUT',
			'ApiShowController@update',
			[$show->id],
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
			'ApiShowController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$show = Show::all()->first();
		$response = $this->action(
			'PUT',
			'ApiShowController@update',
			[$show->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(500);
	}
	public function testDestroy()
	{
		$this->seed();
		$show = Show::all()->first();
		$id = $show->id;
		$response = $this->action(
			'DELETE',
			'ApiShowController@destroy',
			[$show->id]
		);

		$this->assertResponseOk();

		$show = Show::find($id);
		$this->assertNUll($show);

	}
	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiShowController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}
}
