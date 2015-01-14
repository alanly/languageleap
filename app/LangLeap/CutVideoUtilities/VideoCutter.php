<?php namespace LangLeap\VideoCutterUtilities;

use LangLeap\Core\Collection;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoCutter implements IVideoCutter
{
	private $videoCutter;
	private $videoFormatter;
	private $media_id;
	private $mediaType;

	public __construct($video, $media_id, $mediaType)
	{
		$this->videoCutter = VideoCutterFactory::getInstance()->getFFmpeg($video->path);
		$this->videoFormatter = VideoCutterFactory::getInstance()->getFFprobe($video->path);
		$this->media_id = $media_id;
		$this->mediaType = $mediaType;
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$cutOffTimes = $this->getEqualCutOffTimes($numberOfSegments);
	}

	public function cutVideoAtLocation($cutOffTimes)
	{
		
	}

	private function cutAt($start, $duration)
	{

	}

	private function getTimeCode($seconds)
	{
		return FFMpeg\Coordinate\TimeCode::fromSeconds($seconds);
	}

	private function getEqualCutOffTimes($numberOfSegments)
	{
		$duration = $this->getVideoDuration();
		$secondsPerVideo = intval($duration/$numberOfSegments);

		$this->getTimesToCut($secondsPerVideo, $duration);
	}

	private function getTimesToCut($secondsPerVideo, $duration)
	{
		$currentTime = 0;
		$arrayOfTimes = array();

		while($currentTime < $duration)
		{
			
		}
	}

	private function getVideoDuration()
	{
		$duration = $this->videoFormatter->get("duration");
		return intval($duration);
	}
}

