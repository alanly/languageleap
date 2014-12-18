<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Words\Definition;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class FrenchDictionary implements IDictionary
{
	public function getDefinition($word)
	{
		//Make request here
		$dictionaryDefinition = "CHIEN";

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
		$dictionaryDefinition = "CHIEN";

		if(!$dictionaryDefinition)
		{
			return null;
		}
		
		$def = new Definition;
		$def->definition = $dictionaryDefinition;
		
		return $def;
	}
}

