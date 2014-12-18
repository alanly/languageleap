<?php

use LangLeap\DictionaryUtilities\DictionaryFactory;
use LangLeap\Words\Definition;

class ApiDictionaryController extends \BaseController 
{
	
	/**
	 * Display the specified resource.
	 *
	 * @param  string  $word
	 * @return Response
	 */
	public function show($word)
	{
		$def = DictionaryFactory->getInstance()->getDefinition($word);

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
	
}