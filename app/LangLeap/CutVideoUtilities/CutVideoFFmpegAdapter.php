<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Videos\Video;
use FFMpeg;

/**
 * CutVideoAdapter implementation using PHP-FFMpeg library.
 *
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoFFmpegAdapter implements ICutVideoAdapter
{
	private $AUDIO_CODEC = "libmp3lame";

	public function cutVideoByTimes(Video $video, array $segments)
	{
		$uncut_path = $video->path;
		
	
		$videos = [];
		for($i = 0; $i < count($segments); $i++)
		{
			$cut_path = $this->getVideoPath($video, $i + 1); 
			$start = FFMpeg\Coordinate\TimeCode::fromSeconds($segments[$i]['time']);
			$duration = FFMpeg\Coordinate\TimeCode::fromSeconds($segments[$i]['duration']);
			$codec = $this->AUDIO_CODEC;
			
			\Queue::push(function($job) use ($start, $duration, $uncut_path, $cut_path, $codec)
			{
				$ffmpeg = FFMpeg::create();
				
				$ffmpeg_video = $ffmpeg->open(app_path() . DIRECTORY_SEPARATOR . $uncut_path);
				$ffmpeg_video->filters()->clip($start, $duration);
				$ffmpeg_video->save(new FFMpeg\Format\Video\X264($codec), app_path() . DIRECTORY_SEPARATOR . $cut_path);
				
				$job->delete();
			});
		
			array_push($videos, $this->createVideoAssociation($video, $cut_path));
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
}