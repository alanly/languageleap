<?php

use LangLeap\WordUtilities\ScriptFile;
use LangLeap\ScriptUtilities\ParserFactory;
use LangLeap\ScriptUtilities\FactoryType;

class ApiParseScriptController extends \BaseController {

	/**
	* For the time being, we only support SRT parsing, therefore,
	* we will leave the factory as a class member.
	* @var
	*/
	protected $subRipParserFactory;

	public function __construct()
	{
		$this->subRipParserFactory = ParserFactory::getFactory(FactoryType::SUBRIP);
	}

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

		// Parse the subtitles
		$script_contents = $this->subRipParserFactory->getParser()->parse($script_contents);

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
