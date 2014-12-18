<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\DictionaryUtilities\EnglishDictionary;
use LangLeap\DictionaryUtilities\FrenchDictionary;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DictionaryFactory 
{
	private static $instance;
	private static $dictionaries = [];

	public static function getInstance()
	{
		if (!isset(static::$instance)) 
		{
			static::$instance = new static;
		}

		return static::$instance;
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
		if(is_null(static::$dictionaries[strtoupper($language)]))
		{
			static::$dictionaries[strtoupper($language)] = $this->getDictionaryInstance($language);
		}

		return static::$dictionaries[strtoupper($language)];
	}

	private function getDictionaryInstance($language)
	{
		$dictionary = null;

		switch($language)
		{
			case "ENGLISH":
				$dictionary = new EnglishDictionary;
				break;
			case "FRENCH":
				$dictionary = new FrenchDictionary;
				break;
			default:
				$dictionary = null;
				break;
		}

		return $dictionary;
	}


}

