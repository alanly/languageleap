<?php namespace LangLeap\Words;

use LangLeap\TestCase;
use App;

class DefinitionTest extends TestCase {

	/**
	 * Test getting a single definition.
	 *
	 * @return void
	 */
	public function testGetDefinition()
	{
		$def = $this->createDefinition();
		$def->definition = "This is a definition.";
		$def->full_definition = "This is a full definition.";
		$def->pronunciation = "Def-inition.";
		$this->assertNotNull($def);	
	}

	protected function createDefinition()
	{
		return App::make('LangLeap\Words\Definition');
	}
}
