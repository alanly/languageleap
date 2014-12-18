<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\DictionaryUtilities\EnglishDictionary;
use LangLeap\DictionaryUtilities\FrenchDictionary;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
public static class DictionaryFactory 
{
	private DictionaryFactory $instance;
	private Dictionaries $dictionaries = {};

	public static getInstance()
	{
		if($instance == null)
		{
			$instance = $this;
		}

		return $instance;
	}

	public function getDefinition($word, $language)
	{
		$dictionary = $this->getDictionary($language);
		$definition = $dictionary->$getDefinition($word);

		return $definition;
	}

	public function getPronunciation($word, $language)
	{
		$dictionary = $this->getDictionary($language);
		$pronunciation = $dictionary->$getPronunciation($word);

		return $pronunciation;
	}

	private function getDictionary($language)
	{
		if($dictionaries[strtoupper($language)] == null)
		{
			$dictionaries[strtoupper($language)] = $this->getDictionaryInstance($language); 
		}

		return $dictionaries[strtoupper($language)];
	}

	private function getDictionaryInstance($language)
	{
		if($language == "ENGLISH")
		{
			return new EnglishDictionary;
		}

		if($language == "FRENCH")
		{
			return new FrenchDictionary;
		}
	}


}

