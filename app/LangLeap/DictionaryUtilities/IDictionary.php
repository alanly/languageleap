<?php namespace LangLeap\DictionaryUtilities;

use LangLeap\Core\Collection;
use LangLeap\Words\Definition;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
interface IDictionary 
{
	public function getDefinition($word);
	public function getAudio($word);
	public function getHyphenatedWord($word);
}

