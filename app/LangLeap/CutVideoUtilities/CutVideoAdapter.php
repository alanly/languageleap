<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use LangLeap\CutVideoUtilities\CutVideo;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoAdapter
{
	private $videoCutter;

	function __construct($video, $media_id, $mediaType)
	{
		$this->videoCutter = new CutVideo($video, $media_id, $mediaType);
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$this->videoCutter->cutVideoIntoSegmets($numberOfSegments);
	}

	public function cutVideoAtSpecifiedLocations($cutOffTimes)
	{
		$this->videoCutter->cutVideoAtLocation($numberOfSegments);
	}
}

