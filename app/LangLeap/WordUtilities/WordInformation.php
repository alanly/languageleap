<?php namespace LangLeap\WordUtilities;

use LangLeap\Videos\Video;
use LangLeap\Core\Language;
use LangLeap\Words\Definition;
use LangLeap\DictionaryUtilities\DictionaryFactory;

/**
 * This class will contain a word, its definition and the sentence the word can be found in. 
 * 
 * @author Dror Ozgaon <dror.ozgaon@gmail.com>
 */
class WordInformation
{
	private $word 		= "";
	private $definition 	= "";
	private $sentence 	= "";
	private $definition_id = -1;
	private $BLANK		= "**BLANK**";

	public function __construct($word, $definition, $sentence, $videoId)
	{
		$this->word = $word;

		// Definition does not exist, fetch it.
		if(strlen($definition) < 1)
		{
			$this->definition = $this->getWordDefinition($word, $videoId);
		}
		else
		{
			$this->definition = $definition;
		}

		$this->sentence = str_replace($word, $this->BLANK, $sentence);
	}

	public function getWord()
	{
		return $this->word;
	}

	public function getDefinition()
	{
		return $this->definition;
	}

	public function getSentence()
	{
		return $this->sentence;
	}
	
	public function getDefinitionId()
	{
		return $this->definition_id;
	}

	private function getWordDefinition($word, $videoId)
	{
		$videoLanguage = $this->getVideoLanguage($videoId);
		if(!$videoLanguage) return '';

		$dictionary = DictionaryFactory::getInstance()->getDictionary($videoLanguage);
		if(!$dictionary) return '';

		$definition = Definition::where('word', '=', $word)->first();
		
		if(!$definition)
		{
			$definition = $dictionary->getDefinition($word);
			if(!$definition) return '';
			
			$definition = Definition::create([
				'word' => $word,
				'definition' => $definition->definition,
				'full_definition' => $definition->definition,
				'pronunciation' => $definition->pronunciation,
			]);
		}
		
		$this->definition_id = $definition->id;
		
		return $definition->definition;
	}

	private function getVideoLanguage($id)
	{
		$video = Video::find($id);

		if(!$video) return '';

		$language = Language::find($video->language_id);

		if(!$language) return '';

		return strtoupper($language->code);

	}
}
