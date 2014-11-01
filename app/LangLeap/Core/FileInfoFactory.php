<?php namespace LangLeap\Core;

use SplFileInfo;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class FileInfoFactory {

	/**
	 * Generates a new instance of SplFileInfo for a specified file path.
	 * 
	 * @param  string $filePath
	 * @return SplFileInfo
	 */
	public function makeInstance($filePath)
	{
		return new SplFileInfo($filePath);
	}
	
}
