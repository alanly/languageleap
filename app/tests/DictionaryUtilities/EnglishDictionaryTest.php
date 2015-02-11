<?php

use LangLeap\TestCase;
use LangLeap\DictionaryUtilities\EnglishDictionaryWordnikAdapter;

class EnglishDictionaryTest extends TestCase
{

	public function testGettingADefinitionFromTheApi()
	{
		$dict = new EnglishDictionaryWordnikAdapter;

		$definition = $dict->getDefinition('cat');

		$this->assertNotNull($definition);
		$this->assertSame('terrible, disastrous.', $definition->definition);
	}
	
}
