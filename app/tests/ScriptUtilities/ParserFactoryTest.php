<?php namespace LangLeap\ScriptUtilities;

use LangLeap\TestCase;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class ParserFactoryTest extends TestCase {

	public function testCorrectFactoryReturned()
	{
		$type = FactoryType::SUBRIP;

		$factory = ParserFactory::getFactory($type);

		$this->assertInstanceOf('LangLeap\ScriptUtilities\ParserFactory', $factory);
		$this->assertInstanceOf('LangLeap\ScriptUtilities\SubRipParserFactory', $factory);
	}
	
}