<?php 

use LangLeap\TestCase;
use LangLeap\Words\Word;


/**
*
*	@author Dror Ozgaon <Dror.Ozgaon@gmail.com>
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

		$word = Word::find(1);

		$response = $this->action('POST', 'FlashcardController@postIndex', [], array("word1" => 1));
		$this->assertResponseOk();

		$view = $response->original;

		$this->assertEquals($word['word'], $view['words'][0]['word']);
		//$this->assertEquals($word['pronounciation'], $view['pronounciation']); Uncomment this when it's fixed in the DB
		$this->assertEquals($word['definition'], $view['words'][0]['definition']);
		$this->assertEquals($word['full_definition'], $view['words'][0]['full_definition']);
	}
}
