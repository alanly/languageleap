<?php namespace LangLeap\WordUtilities;

class ScriptFile{

	/**
	*	@author Thomas Rahn <thomas@rahn.ca>
	*
	*	This function accepts a text file and will extract/return the contents.  (This function will be removed when admin is hooked up)
	*
	*	@param 		File 	File input from a form
	*
	*	@return 	String 	The text from the file.
	*/
	public static function retrieveText($file)
	{
		$ext = $file->getClientOriginalExtension();

		$contents = "";

		if($ext == "txt")
		{
			$contents = file_get_contents($file);
		}

		return $contents;
	}

	/**
	 *	@author Thomas Rahn <thomas@rahn.ca>
	 *
	 *	This function accepts a SRT file and will extract/return the contents.
	 *
	 *	@param 		File 	File input from a form
	 *	@return 	String 	The text from the file.
	 */
	public static function extractTextFromSRT($file)
	{
		$ext = $file->getClientOriginalExtension();

		$contents = "";

		if($ext == "srt")
		{
			$contents = file_get_contents($file);
		}

		return $contents;
	}

}



