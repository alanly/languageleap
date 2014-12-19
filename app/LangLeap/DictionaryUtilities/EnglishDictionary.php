<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Core\Collection;
use LangLeap\Words\Definition;
use LangLeap\Dictionary\English\Swagger;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class EnglishDictionary implements IDictionary
{
	private $API_KEY = '0d275e6214609368a960d06d0d40810e58033359378726f83';
	private $API_URL = 'http://api.wordnik.com/v4';
	private $DICTIONARY_SOURCE = 'wiktionary';

	/**
	 * Returns a definition of a word
	 *
	 * @param  string  $word
	 * @return Definition
	 */
	public function getDefinition($word)
	{
		//Make request here
		$dictionaryDefinition = $this->getWordDefinition($word);

		if(!$dictionaryDefinition)
		{
			return null;
		}

		$def = new Definition;
		$def->definition = $dictionaryDefinition;
		
		return $def;
	}

	/**
	 * Returns a pronounciation of a word
	 *
	 * @param  string  $word
	 * @return String (URL of audio)
	 */
	public function getPronunciation($word)
	{
		//@TODO
	}

	private function getWordDefinition($word)
	{
		$client = $this->instantiateConnection();
		$wordApi = new WordApi($client);
		//Returns an array of definitions, only take the first one.
		$definitions = $wordApi->getDefinitions($word, $partOfSpeech=null, $sourceDictionaries=$DICTIONARY_SOURCE, $limit=1);
		$this->closeConnection($client);

		return $definitions[0];
	}

	private function instantiateConnection()
	{
		$client = new Swagger($this->$APIKey, $this->$API_URL);

		return $client;
	}

	private function closeConnection($client)
	{
		unset($client);
	}
}

