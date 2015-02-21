<?php namespace LangLeap\ScriptUtilities;

/**
* Defines an interface for a type that can
* be parsed.
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