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
	private $BLANK		= "**BLANK**";

	public function __construct($word, $definition, $sentence, $videoId)
	{
		$this->word = $word;
		$this->definition = $this->getWordDefinition($word, $definition, $videoId);

		$this->sentence = preg_replace('/\b' . $word . '\b/', $this->BLANK, $sentence);
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
	
	private function getWordDefinition($word, $provided_definition, $videoId)
	{
		if($provided_definition)
		{
			return $provided_definition;
		}
		
		$videoLanguage = $this->getVideoLanguage($videoId);
		if(!$videoLanguage) return '';

		$dictionary = DictionaryFactory::getInstance()->getDictionary($videoLanguage);
		if(!$dictionary) return '';

		$word = strtolower($word);
		
		$definition = Definition::where('word', '=', $word)->first();
		if(!$definition)
		{
			$definition = $dictionary->getDefinition($word);
			if(!$definition) return '';
		}
		
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
	
	/**
	 * This function will create word information instances from every word in selectedWords
	 * 
	 * @param array	selectedWords
	 * @param int		video_id
	 * @return array
	 */ 
	public static function fromInput($selectedWords, $video_id)
	{
		$wordsInformation = array();

		for($i = 0; $i < count($selectedWords); $i++)
		{
			// Ensure word exists.
			$word = $selectedWords[$i]['word'];
			if(!$word) continue;

			// Ensure sentence the word is in exists.
			$sentence = $selectedWords[$i]['sentence'];
			if(!$sentence) continue;

			// If the definition doesn't exist, the WordInformation class will fetch the definition.
			$wordInformation = new WordInformation($word, $selectedWords[$i]['definition'], $sentence, $video_id);

			if(strlen($wordInformation->getDefinition()) < 1) continue;

			array_push($wordsInformation, $wordInformation);
		}
		
		return $wordsInformation;
	}
}
