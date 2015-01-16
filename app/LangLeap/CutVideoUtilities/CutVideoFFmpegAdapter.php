<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Videos\Video;
use FFMpeg;
use FFProbe;

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
	private $AUDIO_CODEC = "libvo_aacenc";
	private $VIDEO_PATH_PREFIX = "app\\";

	function __construct()
	{
		$this->ffmpeg = FFMpeg::create();
		$this->ffprobe = FFProbe::create();
	}

	public function cutVideoByTimes(Video $video, array $segments)
	{
		$ffmpeg_video = $this->ffmpeg->open($this->VIDEO_PATH_PREFIX . $video->path);
	
		$videos = [];
		for($i = 0; $i < count($segments); $i++)
		{
			$path = $this->getVideoPath($video, $i + 1); 
		
			$start = FFMpeg\Coordinate\TimeCode::fromSeconds($segments[$i]['time']);
			$duration = FFMpeg\Coordinate\TimeCode::fromSeconds($segments[$i]['duration']);
			
			$ffmpeg_video->filters()->clip($start, $duration);
			$ffmpeg_video->save(new FFMpeg\Format\Video\X264($this->AUDIO_CODEC), $path);
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
		
		return $this->VIDEO_PATH_PREFIX . $videoPath;
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
}