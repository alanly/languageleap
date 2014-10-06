<?php namespace LangLeap;

use Artisan;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

	public function setUp()
	{
		parent::setUp();

		Artisan::call('migrate');
	}
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

}
