<?php namespace LangLeap;

use Artisan;
use Mail;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	public function tearDown()
	{
		parent::tearDown();
		\Mockery::close();
	}

	public function setUp()
	{
		parent::setUp();

		Artisan::call('migrate');

		Mail::pretend();
	}

}
