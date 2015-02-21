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
		
		if(! Input::hasFile("script-file"))
		{
			return $this->apiResponse(
					'error',
					Lang::get('controllers.parse.invalid_file'),
					400
			);			
		}

		$file = Input::file("script-file");

		$script_contents = ScriptFile::extractTextFromSRT($file);

		if(empty($script_contents))
		{
			return $this->apiResponse(
					'error',
					Lang::get('controllers.parse.unreadable'),
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
