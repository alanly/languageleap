<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Core\Collection;
use LangLeap\Words\Definition;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class EnglishDictionary implements IDictionary
{
	private $API_KEY = '0d275e6214609368a960d06d0d40810e58033359378726f83';

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

	public function getPronunciation($word)
	{
		//@TODO
	}

	private function getWordDefinition($word)
	{
		$client = $this->instantiateConnection();
		$wordApi = new WordApi($client);
		$definition = $wordApi->getDefinitions($word, null, null, 1);
	}

	private function instantiateConnection()
	{
		$client = new APIClient($APIKey, 'http://api.wordnik.com/v4');

		return $client;
	}
}

