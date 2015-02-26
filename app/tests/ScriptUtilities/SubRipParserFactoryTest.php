<?php namespace LangLeap\ScriptUtilities;

use LangLeap\TestCase;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class SubRipParserFactoryTest extends TestCase {

	public function testSupRipParserReturned()
	{
		$factory = new SubRipParserFactory();

		$instance = $factory->getParser();

		$this->assertInstanceOf('LangLeap\ScriptUtilities\SubRipParser', $instance);
	}
	
}