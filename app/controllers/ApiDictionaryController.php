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
	public function show()
	{
		// Ensure the word exists.
		$word = Input::get("word");
		if (!$word)
		{
			return $this->apiResponse(
				'error',
				"Word {$word} does not exists",
				404
			);
		}

		// Ensure the video exists.
		$videoId = Input::get("video_id");
		if (!$videoId)
		{
			return $this->apiResponse(
				'error',
				"Video {$videoId} does not exists",
				404
			);
		}

		$videoLanguage = $this->getVideoLanguage($videoId);
		if (!$videoLanguage)
		{
			return $this->apiResponse(
				'error',
				"Language for {$videoId} not found.",
				404
			);
		}

		$dictionary = DictionaryFactory::getInstance()->getDictionary($videoLanguage);
		if (!$dictionary)
		{
			return $this->apiResponse(
				'error',
				"{$videoLanguage} dictionary not found.",
				404
			);
		}

		$definition = $dictionary->getDefinition($word);
		if (!$definition)
		{
			return $this->apiResponse(
				'error',
				"Definition for {$word} not found.",
				404
			);
		}

		return $this->apiResponse("success", $definition->toResponseArray());
	}

	private function getVideoLanguage($id)
	{
		//@TODO Remove this return when LANGLEAP-53 is done.
		return "ENGLISH";

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

		return strtoupper($language->description);

	}
}