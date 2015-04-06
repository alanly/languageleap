<?php namespace LangLeap\ScriptUtilities;

use LangLeap\TestCase;

/**
* @author Michael Lavoie <lavoie6453@gmail.com>
*/
class SubRipParserTest extends TestCase {

	protected function getSubtitleText()
	{
		return	"1\n" .
				"00:00:02,810 --> 00:00:06,002 X1:53 X2:303 Y1:438 Y2:453\n" .
				"Kids, Im gonna tell you an incredible story\n\n" .
				"2\n" .
				"00:00:06,002 --> 00:00:08,263\n" .
				"<font>the story of <i>how I met</i> your mother.</font>\n\n" .
				"3\n" .
				"00:00:08,263 --> 00:00:10,551\n" .
				"{u}Are we being punished for something ?{/u}\n\n";
	}

	protected function getExpectedParsedText()
	{
		return	'<span data-type="actor" data-timestamp="00:00:02">Speaker</span> <br>' .
				'Kids, Im gonna tell you an incredible story<br><br>' .
				'<span data-type="actor" data-timestamp="00:00:06">Speaker</span> <br>' .
				'the story of how I met your mother.<br><br>' .
				'<span data-type="actor" data-timestamp="00:00:08">Speaker</span> <br>' .
				'Are we being punished for something ?<br><br>';
	}

	public function testParseSuccess()
	{
		$parser = new SubRipParser();

		$input = $this->getSubtitleText();
		$expected = $this->getExpectedParsedText();

		$parsedText = $parser->parse($input);

		$this->assertSame($expected, $parsedText);
	}

	public function testParseFailOnNullInput()
	{
		$parser = new SubRipParser();

		$parsedText = $parser->parse(null);

		$this->assertNull($parsedText);
	}

	public function testParseFailOnNonStringInput()
	{
		$parser = new SubRipParser();

		$parsedText = $parser->parse(8);

		$this->assertNull($parsedText);
	}
	
}