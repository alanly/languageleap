<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use LangLeap\CutVideoUtilities\CutVideoFactory;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideo implements ICutVideo
{
	private $videoCutter;
	private $videoFormatter;
	private $media_id;
	private $mediaType;

	function __construct($video, $media_id, $mediaType)
	{
		$this->videoCutter = CutVideoFactory::getInstance()->getFFmpeg($video->path);
		$this->videoFormatter = CutVideoFactory::getInstance()->getFFprobe($video->path);
		$this->media_id = $media_id;
		$this->mediaType = $mediaType;
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$cutOffTimes = $this->getEqualCutoffTimes($numberOfSegments);
	}

	public function cutVideoAtSpecifiedLocations($cutOffTimes)
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

		return $this->getTimesToCut($secondsPerVideo, $duration);
	}

	private function getTimesToCut($secondsPerVideo, $duration)
	{
		$currentTime = 0;
		$cutoffTimes = array();

		while($currentTime < $duration)
		{
			$timeAndDuration = ["time" => $currentTime, "duration" => $secondsPerVideo];
			array_push($cutoffTimes, $timeAndDuration);
			$currentTime += $secondsPerVideo;
		}
		
		return $cutoffTimes;
	}

	private function getVideoDuration()
	{
		$duration = $this->videoFormatter->get("duration");
		return intval($duration);
	}
}

