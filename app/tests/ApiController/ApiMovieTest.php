<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Movie;
use LangLeap\Levels\Level;


/**
 * @author Thomas Rahn <Thomas@rahn.ca>
 */
class ApiMovieTest extends TestCase {

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiMovieController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	public function testShow()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiMovieController@show', [1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();

		$data = $response->getData()->data;

		$this->assertObjectHasAttribute('videos', $data);
		$this->assertObjectHasAttribute('name', $data);

		$this->assertEquals(1, $data->id);
	}

	public function testShowWithInvalidId()
	{
		$this->seed();
		$response = $this->action('GET', 'ApiMovieController@show', [-1]);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testStore()
	{
		$this->seed();
		$level = Level::first();

		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'Test', 'level_id' => $level->id]
		);

		$this->assertResponseStatus(201);

		$data = $response->getData();

		$this->assertEquals('success', $data->status);
	}

	public function testUpdate()
	{
		$this->seed();

		$movie = Movie::all()->first();
		$response = $this->action(
			'PUT',
			'ApiMovieController@update',
			[$movie->id],
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
			'ApiMovieController@update',
			[-1],
			['name' => 'Test']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(404);
	}

	public function testUpdateWithInvalidName()
	{
		$this->seed();

		$movie = Movie::all()->first();
		$response = $this->action(
			'PUT',
			'ApiMovieController@update',
			[$movie->id],
			['name' => '']
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}

	public function testDestroy()
	{
		$this->seed();
		$movie = Movie::all()->first();
		$id = $movie->id;
		$response = $this->action(
			'DELETE',
			'ApiMovieController@destroy',
			[$movie->id]
		);

		$this->assertResponseStatus(204);

		$movie = Movie::find($id);
		$this->assertNUll($movie);

	}

	public function testDestroyWithInvalidID()
	{
		$response = $this->action(
			'DELETE',
			'ApiMovieController@destroy',
			[-1]
		);

		$this->assertResponseStatus(404);
	}

	public function testUpdatingAnExistingScriptShouldSuccess() {
		$this->seed();

		$movie = App::make('LangLeap\Videos\Movie');
		$movie = $movie->first();

		$response = $this->action(
			'PATCH',
			'ApiMovieController@updateScript',
			$movie->id,
			['text' => 'test']
		);

		$this->assertResponseOk();
	}

	/**
	 * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function testUpdatingTheScriptForANonexistantMovieShouldFailWithException()
	{
		$this->seed();

		$movie = App::make('LangLeap\Videos\Movie');

		$response = $this->action(
			'PATCH',
			'ApiMovieController@updateScript',
			0,
			['text' => 'test']
		);
	}

	/**
	 * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function testUpdatingTheScriptForAMovieWithNoVideosShouldFailWithException()
	{
		$movie = App::make('LangLeap\Videos\Movie');

		$movie->create(['name' => 'test', 'description' => 'test']);

		$response = $this->action(
			'PATCH',
			'ApiMovieController@updateScript',
			$movie->id,
			['text' => 'test']
		);
	}

	/**
	 * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function testUpdatingTheScriptForAMovieWithNoAssociatedScriptsFailsWithException()
	{
		$movie = App::make('LangLeap\Videos\Movie');
		$movie->create(['name' => 'test', 'description' => 'test']);

		$video = App::make('LangLeap\Videos\Video');
		$video->path = '...';
		$video->viewable_id = '0';
		$video->viewable_type = 'test';
		$video->language_id = '0';

		$movie->videos()->save($video);

		$response = $this->action(
			'PATCH',
			'ApiMovieController@updateScript',
			$movie->id,
			['text' => 'test']
		);
	}

	public function testWhenScriptSaveFailsWeGetAnAppropriateResponse()
	{
		$this->seed();

		$movie = App::make('LangLeap\Videos\Movie');
		$movie = $movie->first();

		$script = Mockery::mock('LangLeap\Words\Script');
		$script->shouldReceive('where')->andReturn($script);
		$script->shouldReceive('firstOrFail')->andReturn($script);
		$script->shouldReceive('setAttribute');
		$script->shouldReceive('save')->once()->andReturn(false);
		$script->shouldReceive('getErrors')->once()->andReturn('foobar');

		App::instance('LangLeap\Words\Script', $script);

		$response = $this->action(
			'PATCH',
			'ApiMovieController@updateScript',
			$movie->id,
			['text' => 'test']
		);

		$this->assertResponseStatus(400);
	}

	public function testStoringANewMovieWorksSuccessfully()
	{
		$this->seed();

		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'test', 'description' => 'test']
		);

		$this->assertResponseStatus(201);
	}

	public function testProperResponseWhenSaveFailsDuringStoreRequest()
	{
		$movie = Mockery::mock('LangLeap\Videos\Movie');
		$movie->shouldReceive('newInstance')->andReturn($movie);
		$movie->shouldReceive('save')->andReturn(false);
		$movie->shouldReceive('getErrors')->andReturn('foobar');

		App::instance('LangLeap\Videos\Movie', $movie);

		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'test', 'description' => 'test']
		);

		$this->assertResponseStatus(400);
	}

	public function testProperResponseWhenValidationFails()
	{
		$v = Mockery::mock('Illuminate\Validation\Validator');
		$v->shouldReceive('passes')->andReturn(false);
		$v->shouldReceive('errors')->andReturn('foobar');

		$f = Mockery::mock('Illuminate\Validation\Factory');
		$f->shouldReceive('make')->once()->andReturn($v);

		Validator::swap($f);

		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'test', 'description' => 'test']
		);

		$this->assertResponseStatus(400);
	}

	public function testGivenAnAppropriateUploadWeStoreTheImage()
	{
		$this->seed();
		
		$file = new Symfony\Component\HttpFoundation\File\UploadedFile(
			Config::get('media.test').'/image.jpg',
			'image.jpg', 'image/jpeg', null, null, true);

		$response = $this->action(
			'POST',
			'ApiMovieController@store',
			[],
			['name' => 'test', 'description' => 'test'],
			['media_image' => $file]
		);

		$this->assertResponseStatus(201);
	}

}
