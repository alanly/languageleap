<?php 

use LangLeap\TestCase;

/**
 * @author Thomas Rahn <Thomas@rahn.ca>
 */
class LanguagecontrollerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
	}

	public function testSetLanguage()
	{
		$response = $this->action(
			'GET',
			'LanguageController@setLanguage',
			["fr"],
			[]
		);

		$this->assertSessionHas('lang', 'fr');
	}
}