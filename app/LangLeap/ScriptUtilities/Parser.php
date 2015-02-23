<?php namespace LangLeap\ScriptUtilities;

/**
* Defines a standard interface for the implementing parsing
* utilities/engines which perform an operation over a given data.
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
interface Parser {

	/**
	* Parses the input text into the format supported by
	* the system.
	* @param   string       $input  The text to be parsed
	* @return  string|null          The parsed text or null if invalid
	*/
	public function parse($input);

}