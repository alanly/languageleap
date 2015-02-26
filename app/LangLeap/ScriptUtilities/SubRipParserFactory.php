<?php namespace LangLeap\ScriptUtilities;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class SubRipParserFactory extends ParserFactory {

	public function getParser()
	{
		return new SubRipParser();
	}

}