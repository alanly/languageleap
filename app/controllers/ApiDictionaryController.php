<?php

use LangLeap\DictionaryUtilities\DictionaryFactory;
use LangLeap\Words\Definition;
use LangLeap\Videos\Video;
use LangLeap\Core\Language;

class ApiDictionaryController extends \BaseController 
{
	
	/**
	 * Display the specified resource.
	 *
	 * @param  string  $word
	 * @return Response
	 */
	public function index()
	{
		// Ensure the word exists.
		$word = Input::get("word");
		if (!$word)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.dictionary.word_error', $word),
				404
			);
		}

		// Ensure the video exists.
		$videoId = Input::get("video_id");
		if (!$videoId)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.dictionary.video_error', $videoId),
				404
			);
		}

		$videoLanguage = $this->getVideoLanguage($videoId);
		if (!$videoLanguage)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.dictionary.video_error', $videoId),
				404
			);
		}

		$dictionary = DictionaryFactory::getInstance()->getDictionary($videoLanguage);
		if (!$dictionary)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.dictionary.dictionary_error', $videoLanguage),
				404
			);
		}

		$definition = $dictionary->getDefinition($word);
		if (!$definition)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.dictionary.definition_error'),
				404
			);
		}

		return $this->apiResponse("success", $definition->toResponseArray());
	}

	private function getVideoLanguage($id)
	{
		$video = Video::find($id);

		if (!$video)
		{
			return null;
		}

		$language = Language::find($video->language_id);

		if(!$language)
		{
			return null;
		}

		return strtoupper($language->code);
	}
}