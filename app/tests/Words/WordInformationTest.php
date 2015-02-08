<?php namespace LangLeap\WordUtilities;

use LangLeap\TestCase;
use LangLeap\Videos\Video;
use App;

class WordInformationTest extends TestCase 
{
	private $videoId;

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
		$this->assertEquals(str_replace(" ".$word." ", "**BLANK**", $sentence), $wordInformation->getSentence());
	}

	public function testGetDefinitionEmpty()
	{
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
