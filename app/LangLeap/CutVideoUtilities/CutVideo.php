<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\Collection;
use LangLeap\CutVideoUtilities\CutVideoFactory;
use LangLeap\Videos\Video;
use FFMpeg;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideo implements ICutVideo
{
	private $cutVideo;
	private $videoFormatter;
	private $video;
	private $AUDIO_CODEC = "libvo_aacenc";
	private $NUMBER_OF_ZEROES_VIDEO_NAME = 3;

	function __construct($video)
	{
		$this->cutVideo = CutVideoFactory::getInstance()->getFFmpeg($video->path);
		$this->videoFormatter = CutVideoFactory::getInstance()->getFFprobe($video->path);
		$this->video = $video;
	}

	public function cutVideoIntoSegmets($numberOfSegments)
	{
		$cutoffTimes = $this->getEqualCutoffTimes($numberOfSegments);
		$this->cutVideoAtSpecifiedTimes($cutoffTimes);
	}

	public function cutVideoAtSpecifiedTimes($cutOffTimes)
	{
		$counter = 1;

		foreach($cutOffTimes as $time)
		{
			$this->cutAt($time["time"], $time["duration"], $counter++);
		}
	}

	private function cutAt($start, $duration, $counter)
	{	
		$this->cutVideo->filters()->clip($this->getTimeCode($start), $this->getTimeCode($duration));
		$videoPath = $this->getVideoPath($counter);
		$this->cutVideo->save(new FFMpeg\Format\Video\X264($this->AUDIO_CODEC), $videoPath);
		$this->createVideoAssociation($videoPath);
	}

	private function getVideoPath($counter)
	{
		$videoName = $this->getVideoName($counter);
		$lastSlashPosition = strrpos($this->video->path, "\\");
		$videoPath = substr($this->video->path, 0, $lastSlashPosition + 1) . $videoName;

		return "app\\" . $videoPath;
	}

	private function getVideoName($counter)
	{
		$lastSlashPosition = strrpos($this->video->path, "\\");
		$lastDotPosition = strrpos($this->video->path, ".");
		$fileName = substr($this->video->path, $lastSlashPosition + 1, $lastDotPosition - $lastSlashPosition - 1);
		$number = sprintf("%03d", $counter);
		$fileName = $fileName . "_" . $number;

		return $fileName . ".mp4";
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
		$cutoffTimes = [];

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