<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Words\Definition;
use Picnik;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class EnglishDictionary implements IDictionary
{
	private $API_KEY = '0d275e6214609368a960d06d0d40810e58033359378726f83';
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

		//Returns an array of Definition Objects, only take the text of the first one.
		$definitions = $client->wordDefinitions($word)
		                      ->sourceDictionaries($this->DICTIONARY_SOURCE)
		                      ->limit(1)
		                      ->includeRelated(false)
		                      ->useCanonical(true)
		                      ->get();

		if(! $definitions)
		{
			return null;
		}

		$this->closeConnection($client);

		return $definitions[0]->text;
	}

	private function instantiateConnection()
	{
		$client = new Picnik;
		$client->setApiKey($this->API_KEY);
		return $client;
	}

	private function closeConnection($client)
	{
		unset($client);
	}
}

