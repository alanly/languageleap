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
	private $NUMBER_OF_SYNONYMS = 3;
	private $client = null;


	/**
	 * Returns a definition of a word
	 *
	 * @param  string  $word
	 * @return Definition
	 */
	public function getDefinition($word)
	{
		$this->openConnection();
		$dictionaryDefinition = $this->getWordDefinition($word);
		$audioUrl = $this->getAudio($word);
		$hyphenatedWord = $this->getHyphenatedWord($word);
		$synonym = $this->getSynonym($word);

		if(!$dictionaryDefinition)
		{
			$this->closeConnection();
			return null;
		}

		$def = new Definition;
		$def->definition = $dictionaryDefinition;
		$def->audio_url = $audioUrl;
		$def->pronunciation = $hyphenatedWord;
		$def->synonym = $synonym;
		

		$this->closeConnection();
		return $def;
	}

	/**
	 * Returns the audio of a word
	 *
	 * @param  string  $word
	 * @return string (URL of audio)
	 */
	public function getAudio($word)
	{
		$audios = $this->client->wordAudio($word)
							->limit(1)
							->useCanonical(true)
							->get();

		if (!$audios)
		{
			return null;
		}

		return $audios[0]->fileUrl;
	}

	/**
	 * Returns the synonym of a word
	 *
	 * @param  string  $word
	 * @return string
	 */
	public function getSynonym($word)
	{
		$synonyms = $this->client->wordRelatedWords($word)->limit($this->NUMBER_OF_SYNONYMS)->relationshipTypes('synonym')->get();
		if(!$synonyms)
		{
			return null;
		}

		$words = $synonyms[0]->words;
		if(!$words)
		{
			return null;
		}

		$delimitedSynonyms = '';

		for($i = 0; $i < count($words); $i++)
		{
			$delimitedSynonyms .= $words[$i];

			if($i < count($words) - 1)
			{
				$delimitedSynonyms .= ', ';
			}
		}

		return $delimitedSynonyms;
	}

	/**
	 * Returns the hyphenated version of a word
	 *
	 * @param  string  $word
	 * @return string
	 */
	public function getHyphenatedWord($word)
	{
		$wordSegments = $this->client->wordHyphenation($word)
							->limit(20)
							->useCanonical(true)
							->get();

		if (!$wordSegments)
		{
			return null;
		}
		
		return $this->parseToHyphenatedString($wordSegments);;
	}

	private function parseToHyphenatedString($wordSegments)
	{
		$result = '';
		foreach ($wordSegments as $segment)
		{
			$result .= $segment->text . '-';
		}

		return substr($result, 0, -1);
	}

	private function getWordDefinition($word)
	{
		//Returns an array of Definition Objects, only take the text of the first one.
		$definitions = $this->client->wordDefinitions($word)
							->sourceDictionaries($this->DICTIONARY_SOURCE)
							->limit(1)
							->includeRelated(false)
							->useCanonical(true)
							->get();

		if(!$definitions)
		{
			return null;
		}

		return $definitions[0]->text;
	}

	private function openConnection()
	{
		$this->client = $this->instantiateConnection();
	}

	private function instantiateConnection()
	{
		$client = new Picnik;
		$client->setApiKey($this->API_KEY);
		return $client;
	}

	private function closeConnection()
	{
		unset($this->client);
	}
}

