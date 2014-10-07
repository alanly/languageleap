<?php 

use LangLeap\TestCase;

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
		$this->seed('CommercialTableSeeder');

		$commercial = App::make('LangLeap\Videos\Commercial')->first();
		
		$response = $this->action(
			'GET',
			'ApiCommercialController@show',
			[$commercial->id]
		);

		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	

}