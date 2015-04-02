<?php namespace LangLeap\ScriptUtilities;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class SubRipParser implements Parser {

	public function parse($input)
	{
		if (! $input || ! is_string($input))
			return null;

		// Strips all html type tags
		$parsed = strip_tags($input);

		// Strips all tags such as {i}{/i}, {u}{/u}, etc...
		$parsed = preg_replace('/{.*?}/', '', $parsed);

		// Example of patterns that will match:
		//		1
		//		00:00:02,810 --> 00:00:06,002
		//					or
		//		1
		//		00:00:02,810 --> 00:00:06,002  X1:53 X2:303 Y1:438 Y2:453
		$pattern = '/\d+\s*\n\s*(\d{2}:\d{2}:\d{2}),\d{3}\s-->\s\d{2}:\d{2}:\d{2},\d{3}((\s+.\d:\d+){4})?/';

		// The pattern examples above with this replacement will produce the following:
		//		<span data-type="actor" data-timestamp="00:00:02">Speaker</span>
		$replacement = '<span data-type="actor" data-timestamp="${1}">Speaker</span> ';

		// Parse the timestamps to the correct format
		$parsed = preg_replace($pattern, $replacement, $parsed);

		// All line-breaks are replaced by <br> tags to give a clean presentation of the
		// subtitles to the admin
		$parsed = str_replace("\n", '<br>', $parsed);

		return $parsed;
	}

}