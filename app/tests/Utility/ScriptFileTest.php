<?php 

use LangLeap\TestCase;
use LangLeap\WordUtilities\ScriptFile;

/**
*
* @author Thomas Rahn <Thomas@rahn.ca>
*
*/
class ScriptFileTest extends TestCase {

	public function testGetTextFromSRTFile()
	{
		$this->seed();

		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . 'test-script.srt', 'test-script.srt');

		$script_contents = ScriptFile::extractTextFromSRT($script);

		$this->assertTrue(!empty($script_contents));
	}
	
	public function testInvalidFileType()
	{
		$this->seed();

		$script = new Symfony\Component\HttpFoundation\File\UploadedFile(Config::get('media.test') . DIRECTORY_SEPARATOR . '1.txt', '1.txt');

		$script_contents = ScriptFile::extractTextFromSRT($script);

		$this->assertTrue(empty($script_contents));
	}
}
