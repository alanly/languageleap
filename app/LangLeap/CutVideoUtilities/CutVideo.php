<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use LangLeap\CutVideoUtilities\CutVideo;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideo implements UserInputResponse
{
	private $videoCutter;

	function __construct($video)
	{
		$this->videoCutter = new CutVideo($video);
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$this->videoCutter->cutVideoIntoSegmets($numberOfSegments);
	}

	public function cutVideoAtSpecifiedTimes($cutOffTimes)
	{
		$this->videoCutter->cutVideoAtSpecifiedTimes($cutOffTimes);
	}
}

