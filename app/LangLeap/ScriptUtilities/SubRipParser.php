<?php namespace LangLeap\ScriptUtilities;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class SubRipParser implements Parser {

	public function parse($input)
	{
		if (! $input || ! is_string($input))
			return null;

		// Example of a pattern that will match:
		//		1
		//		00:00:02,810 --> 00:00:06,002
		$pattern = '/\d+\s*\n\s*(\d{2}:\d{2}:\d{2}),\d{3}\s-->\s\d{2}:\d{2}:\d{2},\d{3}/';

		// The pattern example above with this replacement will produce the following:
		//		<span data-type="actor" data-timestamp="00:00:02">Speaker</span>
		$replacement = '<span data-type="actor" data-timestamp="${1}">Speaker</span>';

		$parsed = preg_replace($pattern, $replacement, $input);

		// All line-breaks are replaced by <br> tags to give a clean presentation of the
		// subtitles to the admin
		$parsed = str_replace("\n", '<br>', $parsed);

		return $parsed;
	}

}