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
	public function show($word, $videoId)
	{
		$videoLanguage = $this->getVideoLanguage($videoId);

		if (!$videoLanguage)
		{
			return $this->apiResponse(
				'error',
				"Language for {$videoId} not found.",
				404
			);
		}

		$def = DictionaryFactory::getInstance()->getDefinition($word, $language);

		if (!$def)
		{
			return $this->apiResponse(
				'error',
				"Definition for {$word} not found.",
				404
			);
		}

		return $this->apiResponse("success", $def->toResponseArray());
	}

	private function getVideoLanguage($id);
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

		return strtoupper($language->description);

	}
	
}