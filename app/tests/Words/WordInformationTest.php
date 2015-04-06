<?php namespace LangLeap\WordUtilities;

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use LangLeap\DictionaryUtilities\DictionaryFactory;
use App, Mockery;

class WordInformationTest extends TestCase {
	private $videoId;

	private function getDefinitionMock()
	{
		return Mockery::mock('LangLeap\Words\Definition');
	}

	private function getAdapterMock()
	{
		return Mockery::mock('LangLeap\DictionaryUtilities\IDictionaryAdapter');
	}

	private function getFactoryMock()
	{
		return Mockery::mock('LangLeap\DictionaryUtilities\DictionaryFactory');
	}

	public function setUp()
	{
		parent::setUp();

		// Seed the database.
		$this->seed();
		$this->videoId = Video::all()->first()->id;
	}

	public function testGetWordValid()
	{
		$word = 'cat';
		$wordInformation = new WordInformation($word, 'an annoying animal', 'the cat is annoying', $this->videoId);
		$this->assertEquals($wordInformation->getWord(), $word);	
	}

	public function testGetDefinitionValid()
	{
		$definition = 'an annoying animal';
		$wordInformation = new WordInformation('cat', $definition, 'the cat is annoying', $this->videoId);
		$this->assertEquals($wordInformation->getDefinition(), $definition);	
	}

	public function testGetSentenceValid()
	{
		$word = 'cat';
		$sentence = 'the cat is annoying';
		$wordInformation = new WordInformation($word, 'an annoying animal', $sentence, $this->videoId);
		$this->assertEquals(str_replace($word, "**BLANK**", $sentence), $wordInformation->getSentence());
	}

	public function testGetDefinitionEmpty()
	{
		// Mock the definition instance.
		$definition = $this->getDefinitionMock();
		$definition->shouldReceive('getAttribute')->atLeast()->once()->andReturn('foobar');

		// Mock the dictionary adapter.
		$adapter = $this->getAdapterMock();
		$adapter->shouldReceive('getDefinition')->once()->andReturn($definition);
		
		// Mock the factory.
		$factory = $this->getFactoryMock();
		$factory->shouldReceive('getDictionary')->once()->andReturn($adapter);

		DictionaryFactory::getInstance($factory);

		$definition = '';
		$wordInformation = new WordInformation('cat', $definition, 'the cat is annoying', $this->videoId);
		$this->assertTrue(strlen($wordInformation->getDefinition()) > 1);	
	}

	public function testInvalidVideoId()
	{
		$definition = '';
		$wordInformation = new WordInformation('cat', $definition, 'the cat is annoying', -1);
		$this->assertTrue(strlen($wordInformation->getDefinition()) < 1);	
	}
}
