<?php namespace LangLeap\VideoCutterUtilities;

use LangLeap\Core\Collection;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoCutterAdapter
{
	private $videoCutter;

	public __construct($video, $media_id, $mediaType)
	{
		$this->videoCutter = new VideoCutterAdapter($video, $media_id, $mediaType);
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$videoCutter->cutVideoIntoSegmets($numberOfSegments);
	}

	public function cutVideoAtLocation($cutOffTimes)
	{
		$videoCutter->cutVideoAtLocation($numberOfSegments);
	}
}

