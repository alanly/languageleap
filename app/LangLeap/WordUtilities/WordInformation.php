<?php namespace LangLeap\WordUtilities;

/**
*	@author Dror Ozgaon <dror.ozgaon@gmail.com>
*
*	This class will contain a word, its definition and the sentence the word can be found in.
*/
class WordInformation
{
	private $word 		= "";
	private $defintion 	= "";
	private $sentence 	= "";

	public function __construct($word, $definition, $sentence, $video_id)
	{
		$this->word = $word;

		// Definition does not exist, fetch it.
		if(!definition)
		{
			$this->defintion = $this->getWordDefinition($word, $video_id)
		}
		else
		{
			$this->definition = $definition;
		}
		$this->sentence = $sentence;
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

	private function getWordDefinition($word, $videoId)
	{
		$videoLanguage = $this->getVideoLanguage($videoId);
		if(!$videoLanguage) return null;

		$dictionary = DictionaryFactory::getInstance()->getDictionary($videoLanguage);
		if(!$dictionary) return null;

		$definition = $dictionary->getDefinition($word);
		if(!$definition) return null;

		return $definition->text;
	}

	private function getVideoLanguage($id)
	{
		$video = Video::find($id);

		if(!$video) return null;

		$language = Language::find($video->language_id);

		if(!$language) return null;

		return strtoupper($language->code);

	}


}



