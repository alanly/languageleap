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

	public function testBadFileShouldThrowNotFoundHttpException()
	{
		$movie = App::make('LangLeap\Videos\Movie');
		$movie = $movie->create([
			'name' => 'test',
			'description' => 'test',
			'image_path' => 'foobar',
		]);

		$this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		$response = $this->action('GET', 'ImageContentController@getImage', ['movie', $movie->id]);
	}

	public function testSlashyModelNameThrowsNotFoundHttpException()
	{
		$this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		$response = $this->action('get', 'ImageContentController@getImage', ['\\Model\\', 1]);
	}
	
}
