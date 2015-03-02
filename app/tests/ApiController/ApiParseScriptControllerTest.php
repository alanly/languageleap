<?php 

use LangLeap\TestCase;

/**
*
* @author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ApiParseScriptControllerTest extends TestCase {

	public function testIndex()
	{
		$this->seed();

		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . 'test-script.srt', 'test-script.srt');

		$response = $this->action(
			'POST',
			'ApiParseScriptController@postIndex',
			[],
			[],
			['script-file' => $script]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseOk();
	}

	public function testIndexWithInvalidFileType()
	{
		$this->seed();

		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.txt', '1.txt');

		$response = $this->action(
			'POST',
			'ApiParseScriptController@postIndex',
			[],
			[],
			['script-file' => $script]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}

	public function testIndexWithInvalidNofile()
	{
		$response = $this->action(
			'POST',
			'ApiParseScriptController@postIndex',
			[], [],	[]
		);

		$this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);
		$this->assertResponseStatus(400);
	}
}
