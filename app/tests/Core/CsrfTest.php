<?php

use LangLeap\TestCase;
use Mockery as m;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class CsrfTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		Route::enableFilters();
	}

	public function testCsrfTokenInResponseHeaderIsCorrect()
	{
		$localToken = 'abc123';
		$this->session(['_token' => $localToken]);

		$response = $this->call('GET', '/');

		$this->assertSame($localToken, $response->headers->get('X-Csrf-Token'));
	}

	/**
	 * @expectedException Illuminate\Session\TokenMismatchException
	 */
	public function testIncorrectCsrfTokenInFormRequestThrowsException()
	{
		$localToken = '0000';
		$this->session(['_token' => 'abcd']);
		
		$response = $this->call('POST', 'test/csrf', ['_token' => $localToken]);
	}

	/**
	 * @expectedException Illuminate\Session\TokenMismatchException
	 */
	public function testIncorrectCsrfTokenInRequestHeaderThrowsException()
	{
		$localToken = '0000';
		$this->session(['_token' => 'abcd']);
		
		$response = $this->call('POST', 'test/csrf', [], [], ['HTTP_X-Csrf-Token' => $localToken]);
	}

	public function testCorrectCsrfTokenInFormRequestIsAccepted()
	{		
		$localToken = '0000';
		$this->session(['_token' => $localToken]);

		$response = $this->call('POST', 'test/csrf', ['_token' => $localToken]);
	}

	public function testCorrectCsrfTokenInRequestHeaderIsAccepted()
	{
		$localToken = '0000';
		$this->session(['_token' => $localToken]);
		
		$response = $this->call('POST', 'test/csrf', [], [], ['HTTP_X-Csrf-Token' => $localToken]);
	}

	public function testHeaderTokenDoesNotConflictWithBinaryResponse()
	{
		$localToken = '0000';
		$this->session(['_token' => $localToken]);

		$videoMock = $this->getVideoMock();
		App::instance('LangLeap\Videos\Video', $videoMock);

		$fileInfoFactoryMock = $this->getFileInfoFactoryMock();
		App::instance('LangLeap\Core\FileInfoFactory', $fileInfoFactoryMock);

		$fileInfoMock = $this->getFileInfoMock();
		$fileInfoFactoryMock->shouldReceive('makeInstance')->andReturn($fileInfoMock);

		$response = $this->action('GET', 'VideoContentController@getVideo', [1]);
		$this->assertResponseOk();
	}

	protected function getVideoMock()
	{
		$m = m::mock('LangLeap\Videos\Video');
		$m->shouldReceive('find')->andReturn($m);
		$m->shouldReceive('getAttribute')->andReturn('');

		return $m;
	}

	protected function getFileInfoFactoryMock()
	{
		$m = m::mock('LangLeap\Core\FileInfoFactory');

		return $m;
	}

	protected function getFileInfoMock()
	{
		$m = m::mock('SplFileInfo');
		$m->shouldReceive('isFile')->andReturn(true);
		$m->shouldReceive('isReadable')->andReturn(true);
		$m->shouldReceive('getRealPath')->andReturn('foo');
		$m->shouldReceive('getPathname')->andReturn(__FILE__);

		return $m;
	}
	
}
