<?php

use LangLeap\WordUtilities\ScriptFile;

class ApiParseScriptController extends \BaseController {

	/**
	 * Will recieve a file from the request, extract the contents from that file and parse it into script format.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		$file = Input::file("script-file");

		if(! $file)
		{
			return $this->apiResponse(
					'error',
					'Invalid Script file',
					400
			);			
		}

		$script_contents = ScriptFile::extractTextFromSRT($file);

		if(empty($script_contents))
		{
			return $this->apiResponse(
					'error',
					'Unable to read file',
					400
			);	
		}

		//Encode to be able to return in response
		$script_contents = utf8_encode($script_contents);

		//Call factory here
		return $this->apiResponse(
			'success',
			$script_contents,
			200
		);
	}
}
