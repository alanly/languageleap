<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\DictionaryUtilities\EnglishDictionaryWordnikAdapter;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class DictionaryFactory 
{
	private static $instance;
	private static $dictionaries = [];

	/**
	 * A manually set adapter instance. Used for test purposes to hold a mock
	 * instance of the adapter that should always be returned.
	 * @var LangLeap\DictionaryUtilities\IDictionaryAdapter
	 */
	private $fixedAdapter;

	// Set the constructor to private so that this class cannot be instantiated.
	private function __construct() {}

	public static function getInstance($instance = null)
	{
		if ($instance)
		{
			self::$instance = $instance;
		}

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
		// Return a fixed adapter instance if it exists.
		if ($this->fixedAdapter !== null) return $this->fixedAdapter;

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

	public function setAdapterInstance(IDictionaryAdapter $adapter)
	{
		$this->fixedAdapter = $adapter;
	}

}

