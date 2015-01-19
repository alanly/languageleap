<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Videos\Video;

/**
 * CutVideoAdapter implementation using PHP-FFMpeg library.
 *
 * @author Quang Tran <tran.quang@live.com>
 */
 
 class CutVideoLibavAdapter implements ICutVideoAdapter {
 
	public function cutVideoByTimes(Video $video, array $times)
	{
		$videos = [];
		for($i = 0; $i < count($times); $i++)
		{
			$cut_path = $this->getVideoPath($video, $i + 1); 
			$video_path = $video->path;
			
			$start = $times[$i]['time'];
			$start = sprintf('%02d:%02d:%02d', ($start/3600), ($start/60%60), ($start%60));
			
			$end = $times[$i]['duration'];
			$end = sprintf('%02d:%02d:%02d', ($end/3600), ($end/60%60), ($end%60));
			
			\Queue::push(function($job) use ($start, $end, $video_path, $cut_path)
			{
				$cmd = 'avconv -ss ' . $start . ' -i ' . app_path() . DIRECTORY_SEPARATOR . $video_path . ' -t ' . $end . ' -codec copy ' . app_path() . DIRECTORY_SEPARATOR . $cut_path . ' 2>&1';
				exec($cmd, $output, $return_val);
				
				$libav_output = '';
				foreach($output as $line)
				{
					$libav_output .= $line . "\n";
				}
				
				if($return_val == 0)
				{
					\Log::info("libav output \n" . $libav_output);
				}
				else
				{
					\Log::error("libav output \n" . $libav_output);
				}
				
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
		$cut_video = new Video;
		$cut_video->viewable_type = $video->viewable_type;
		$cut_video->viewable_id = $video->viewable_id;
		$cut_video->language_id = $video->language_id;
		$cut_video->path = $path;
		$cut_video->save();
		return $cut_video;
	}
 }