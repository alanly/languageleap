<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\DictionaryUtilities\EnglishDictionary;
use LangLeap\DictionaryUtilities\FrenchDictionary;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DictionaryFactory 
{
	private $instance;
	private $dictionaries = {};

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
		$dictionary = null;

		switch($language)
		{
			case "ENGLISH":
				$dictionary = new EnglishDictionary;
				break;
			case "FRENCH"
				$dictionary = new FrenchDictionary;
				break;
			default:
				$dictionary = null;
				break;
		}
	}


}

