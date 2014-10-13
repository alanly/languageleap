<?php 

use LangLeap\TestCase;
use LangLeap\Words\Word;

class ApiWordTest extends TestCase {

	/**
	 * Test GET all words.
	 *
	 * @return void
	 */
	public function testShowApi()
	{
		$response = $this->action('GET', 'ApiWordController@index');
		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
	
	public function testGetMultipleDefinitions()
	{
		$this->seed('WordTableSeeder');

		$word = App::make('LangLeap\Words\Word')->first();
		
		$response = $this->action(
			'POST',
			'ApiWordController@getMultipleWords',
			["words"=>[$word->word]]
		);

		$this->assertResponseOk();
		$this->assertJson($response->getContent());
	}
}
