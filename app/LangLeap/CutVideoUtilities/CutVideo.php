<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use LangLeap\CutVideoUtilities\CutVideoFactory;
use LangLeap\Videos\Video;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideo implements ICutVideo
{
	private $cutVideo;
	private $videoFormatter;
	private $media_id;
	private $video;
	private $AUDIO_CODEC = "libvo_aacenc";
	private $NUMBER_OF_ZEROES_VIDEO_NAME = 3;

	function __construct($video, $media_id)
	{
		$this->cutVideo = CutVideoFactory::getInstance()->getFFmpeg($video->path);
		$this->videoFormatter = CutVideoFactory::getInstance()->getFFprobe($video->path);
		$this->media_id = $media_id;
		$this->video = $video;
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$cutOffTimes = $this->getEqualCutoffTimes($numberOfSegments);
	}

	public function cutVideoAtSpecifiedTimes($cutOffTimes)
	{
		$counter = 0;

		for($timeAndDuration as $time)
		{
			$this->cutAt($time[0], $time[1], $counter++)
		}
	}

	private function cutAt($start, $duration, $counter)
	{	
		$this->cutVideo->filters()->clip($this->getTimeCode($start), $this->getTimeCode($duration));
		$videoPath = $this->getVideoPath($counter);
		$this->cutVideo->save(new FFMpeg\Format\Video\X264($AUDIO_CODEC), $videoPath);
		$this->createVideoAssociation($videoPath);
	}

	private function getVideoPath($counter)
	{
		$videoName = $this->getVideoName($counter);
		$lastSlashPosition = strrpos($video->path, "/");
		$videoPath = substr(0, $lastSlashPosition + 1) . $videoName;

		return $videoPath;
	}

	private function getVideoName($counter)
	{
		$name = $this->videoFormatter->get("name");
		$numberOfZeroes = $this->NUMBER_OF_ZEROES_VIDEO_NAME - intval(strlen((string)$num));

		$name = $name . "_";

		for($i = 0; $i < $numberOfZeroes; $i++)
		{
			$name . "0";
		}

		$name = $name . $counter;

		return $name . ".mp4"
	}

	private function createVideoAssociation($path)
	{
		$video = new Video;
		$video->viewable_type = $video->viewable_type;
		$video->viewable_id = $video->viewable_id;
		$video->language_id = $video->language_id;
		$video->path = $path;
		$video->save();
	}

	private function getTimeCode($seconds)
	{
		return FFMpeg\Coordinate\TimeCode::fromSeconds($seconds);
	}

	private function getEqualCutOffTimes($numberOfSegments)
	{
		$duration = $this->getVideoDuration();
		$secondsPerVideo = intval($duration/$numberOfSegments);

		return $this->getCutoffTimes($secondsPerVideo, $duration);
	}

	private function getCutoffTimes($secondsPerVideo, $duration)
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

