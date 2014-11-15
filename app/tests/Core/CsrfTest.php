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

	public function testCsrfTokenInCookieIsCorrect()
	{
		$localToken = 'abc123';
		$this->session(['_token' => $localToken]);

		// Call root twice in order to get the cookie first and respond with it
		// on the second request.
		$response = $this->call('GET', '/');
		$response = $this->call('GET', '/');

		$this->assertTrue(Cookie::has('CSRF-TOKEN'));
		$this->assertSame($localToken, Cookie::get('CSRF-TOKEN'));
	}

	/**
	 * @expectedException Illuminate\Session\TokenMismatchException
	 */
	public function testExceptionThrownWhenIncorrectTokenSuppliedInRequestBody()
	{
		$localToken = '0000';
		$this->session(['_token' => 'abcd']);
		
		$response = $this->call('GET', '/');
		$response = $this->call('POST', 'test/csrf', ['_token' => $localToken]);
	}

	/**
	 * @expectedException Illuminate\Session\TokenMismatchException
	 */
	public function testExceptionThrownWhenIncorrectTokenSuppliedInRequestHeader()
	{
		$localToken = '0000';
		$this->session(['_token' => 'abcd']);
		
		$response = $this->call('GET', '/');
		$response = $this->call('POST', 'test/csrf', [], [], ['HTTP_X-CSRF-TOKEN' => $localToken]);
	}

	/**
	 * @expectedException Illuminate\Session\TokenMismatchException
	 */
	public function testExceptionThrownWhenTokenIsNotSupplied()
	{
		$this->session(['_token' => 'abc']);

		$response = $this->call('GET', '/');
		$response = $this->call('POST', 'test/csrf');
	}

	public function testCorrectTokenInRequestBodyIsAccepted()
	{		
		$localToken = '0000';
		$this->session(['_token' => $localToken]);

		$response = $this->call('GET', '/');
		$response = $this->call('POST', 'test/csrf', ['_token' => $this->client->getCookieJar()->get('CSRF-TOKEN')->getValue()]);
	}

	public function testCorrectTokenInRequestHeaderIsAccepted()
	{
		$localToken = '0000';
		$this->session(['_token' => $localToken]);
		
		$response = $this->call('GET', '/');
		$response = $this->call('POST', 'test/csrf', [], [], ['HTTP_X-CSRF-TOKEN' => $this->client->getCookieJar()->get('CSRF-TOKEN')->getValue()]);
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
