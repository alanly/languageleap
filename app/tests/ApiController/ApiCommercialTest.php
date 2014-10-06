<?php 

use LangLeap\TestCase;
use LangLeap\Videos\Commercial;

class ApiCommercialTest extends TestCase {

	/**
	 * Testing getting all commercials.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'ApiCommercialController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}

	/**
	 * Testing getting all commercials.
	 *
	 * @return void
	 */
	public function testShow()
	{
		$this->seed();
		
		$response = $this->action('GET', 'ApiCommercialController@show', array(Commercial::all()->first()->id));
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	

}