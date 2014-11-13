<?php

use LangLeap\TestCase;

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
	
}
