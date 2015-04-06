<?php

use LangLeap\TestCase;

class ImageContentControllerTest extends TestCase {

	public function testValidModelShouldGiveUsAnImage()
	{
		// Get test image path.
		$path = Config::get('media.test').'/image.jpg';

		$movie = App::make('LangLeap\Videos\Movie');
		$movie = $movie->create([
			'name' => 'test',
			'description' => 'test',
			'image_path' => $path,
			'is_published' => 1
		]);

		$response = $this->action('GET', 'ImageContentController@getImage', ['movie', $movie->id]);

		$this->assertResponseOk();
	}

	public function testBadModelNameShouldThrowNotFoundHttpException()
	{
		$this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		$response = $this->action('get', 'ImageContentController@getImage', ['foo', 'bar']);
	}

	public function testBadIdShouldThrowModelNotFoundException()
	{
		$this->setExpectedException('Illuminate\Database\Eloquent\ModelNotFoundException');
		$response = $this->action('get', 'ImageContentController@getImage', ['movie', 123]);
	}

	public function testBadFileShouldJustReturnADefaultImage()
	{
		$movie = App::make('LangLeap\Videos\Movie');
		$movie = $movie->create([
			'name' => 'test',
			'description' => 'test',
			'image_path' => 'foobar',
			'is_published' => 1
		]);

		$response = $this->action('GET', 'ImageContentController@getImage', ['movie', $movie->id]);

		$this->assertResponseOk();
	}

	public function testSlashyModelNameThrowsNotFoundHttpException()
	{
		$this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		$response = $this->action('get', 'ImageContentController@getImage', ['\\Model\\', 1]);
	}
	
}
