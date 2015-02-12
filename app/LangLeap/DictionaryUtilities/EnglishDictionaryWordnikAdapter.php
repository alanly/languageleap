<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Words\Definition;
use Picnik;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class EnglishDictionaryWordnikAdapter implements IDictionaryAdapter
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
		//Make requests here
		$dictionaryDefinition = $this->getWordDefinition($word);
		$audioUrl = $this->getAudio($word);
		$hyphenatedWord = $this->getHyphenatedWord($word);

		if(!$dictionaryDefinition)
		{
			return null;
		}

		$def = new Definition;
		$def->definition = $dictionaryDefinition;
		$def->audio_url = $audioUrl;
		$def->pronunciation = $hyphenatedWord;
		
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
		$client = $this->instantiateConnection();

		$audios = $client->wordAudio($word)
							->limit(1)
							->useCanonical(true)
							->get();

		$this->closeConnection($client);
		if (!$audios)
		{
			return null;
		}

		return $audios[0]->fileUrl;
	}

	/**
	 * Returns the hyphenated version of a word
	 *
	 * @param  string  $word
	 * @return string
	 */
	public function getHyphenatedWord($word)
	{
		$client = $this->instantiateConnection();

		$wordSegments = $client->wordHyphenation($word)
							->limit(20)
							->useCanonical(true)
							->get();

		$this->closeConnection($client);
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
		$client = $this->instantiateConnection();

		//Returns an array of Definition Objects, only take the text of the first one.
		$definitions = $client->wordDefinitions($word)
							->sourceDictionaries($this->DICTIONARY_SOURCE)
							->limit(1)
							->includeRelated(false)
							->useCanonical(true)
							->get();

		$this->closeConnection($client);
		if(!$definitions)
		{
			return null;
		}

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

