<?php

use LangLeap\TestCase;
use LangLeap\DictionaryUtilities\EnglishDictionary;

class EnglishDictionaryTest extends TestCase
{

	public function testGettingADefinitionFromTheApi()
	{
		$dict = new EnglishDictionary;

		$definition = $dict->getDefinition('cat');

		$this->assertNotNull($definition);
		$this->assertSame('terrible, disastrous.', $definition->definition);
	}
	
}
