<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Videos\Video;

/**
 * CutVideoAdapter implementation using PHP-FFMpeg library.
 *
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoFFmpegAdapter implements ICutVideoAdapter
{
	private $ffmpeg;
	private $ffprobe;
	
	private $NUMBER_OF_ZEROES_VIDEO_NAME = 3;
	private $MINIMUM_VIDEO_LENGTH = 5;

	function __construct()
	{
		$this->ffmpeg = \FFMpeg\FFMpeg::create();
		$this->ffprobe = \FFMpeg\FFProbe::create();
	}

	public function cutVideoIntoSegments(Video $video, int $numberOfSegments)
	{
		// Get equal time segments and use the cut by times function
		$duration = intval($this->ffprobe->format($video->path)->get('duration'));
		$secondsPerVideo = intval($duration/$numberOfSegments);
		$cutoffTimes = $this->getCutoffTimes($secondsPerVideo, $duration);
		
		return $this->cutVideoByTimes($video, $cutoffTimes); 
	}

	public function cutVideoByTimes(Video $video, array $cutOffTimes)
	{
		$ffmpeg_video = $this->ffmpeg->open($video->path);
	
		$videos = [];
		for($i = 0; $i < count($cutOffTimes); $i++)
		{
			$path = $this->getVideoPath($video, $i + 1); 
		
			$start = FFMpeg\Coordinate\TimeCode::fromSeconds($cutOffTimes[$i]['time']);
			$duration = FFMpeg\Coordinate\TimeCode::fromSeconds($cutOffTimes[$i]['duration']);
			
			$filter = $ffmpeg_video->filters()->clip($start, $duration);
			$ffmpeg_video->addFilter($filter);
			$ffmpeg_video->save(new FFMpeg\Format\Video\X264(), $path);
			array_push($videos, $this->createVideoAssociation($video, $path));
		}
		
		return $videos;
	}

	/**
	 * Create a path to a new video clip by using the original video's name and adding a number at the end.
	 */
	private function getVideoPath($video, $counter)
	{
		$number = sprintf("%03d", $counter);
		
		$lastDotPosition = strrpos($video->path, ".");
		$videoPath = substr($video->path, 0, $lastDotPosition) . '_' . $number . '.mp4';
		
		return $videoPath;
	}

	private function createVideoAssociation($video, $path)
	{
		$video = new Video;
		$video->viewable_type = $video->viewable_type;
		$video->viewable_id = $video->viewable_id;
		$video->language_id = $video->language_id;
		$video->path = $path;
		$video->save();
		return $video;
	}

	private function getCutoffTimes($secondsPerVideo, $duration)
	{
		$currentTime = 0;
		$cutoffTimes = [];

		while($currentTime < $duration)
		{
			if(($duration - $currentTime) < $this->MINIMUM_VIDEO_LENGTH)
			{
				break;
			}
			$timeAndDuration = ["time" => $currentTime, "duration" => $secondsPerVideo];
			array_push($cutoffTimes, $timeAndDuration);
			$currentTime += $secondsPerVideo;
		}
		
		return $cutoffTimes;
	}
}