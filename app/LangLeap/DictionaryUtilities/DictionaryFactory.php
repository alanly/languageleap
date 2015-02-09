<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\DictionaryUtilities\EnglishDictionaryWordnikAdapter;

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

	/**
	 * Returns the dictionary adapter object
	 *
	 * @param $language
	 * @return Dictionary adapter
	 */
	public function getDictionary($language)
	{
		$dictionary = $this->getAndSetDictionary($language);

		return $dictionary;
	}

	/**
	 * Sets the dictionary in memory, and then returns it
	 *
	 * @param $language
	 * @return Dictionary adapter
	 */
	private function getAndSetDictionary($language)
	{
		if(!array_key_exists(strtoupper($language), static::$dictionaries))
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
			case "EN":
				$dictionary = new EnglishDictionaryWordnikAdapter;
				break;
			default:
				$dictionary = null;
				break;
		}

		return $dictionary;
	}


}

