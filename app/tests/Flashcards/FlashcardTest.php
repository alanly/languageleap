<?php

use LangLeap\TestCase;
use LangLeap\Words\Definition;


/**
*
*	@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
*	@author Thomas Rahn <thomas@rahn.ca>
*
*/
class FlashcardTest extends TestCase {

	/**
	 * Test geting all movies.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$this->seed();

		$word = Definition::find(1);
		$response = $this->action('POST', 'FlashcardController@postIndex', [], array("definitions" => array(1)));
		$this->assertResponseOk();

		$view = $response->original;

		$this->assertEquals($word['word'], $view['words'][0]['word']);
		$this->assertEquals($word['definition'], $view['words'][0]['definition']);
		$this->assertEquals($word['full_definition'], $view['words'][0]['full_definition']);
	}
}
