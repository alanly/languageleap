<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Core\Collection;
use LangLeap\Words\Definition;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class EnglishDictionary implements IDictionary
{
	public function getDefinition($word)
	{
		//Make request here
		$dictionaryDefinition = "DOGGY";

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
		//Make request here
		$dictionaryDefinition = "DOGGY";

		if(!$dictionaryDefinition)
		{
			return null;
		}
		
		$def = new Definition;
		$def->definition = $dictionaryDefinition;
		
		return $def;
	}
}

