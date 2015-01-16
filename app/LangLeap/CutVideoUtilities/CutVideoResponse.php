<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\UserInputResponse;
use LangLeap\CutVideoUtilities\CutVideoFFmpegAdapter;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoResponse implements UserInputResponse
{
	public function response(User $user, array $input)
	{
		$video_id = $input['video_id'];
		$segments = $input['segments'];
		
		if(is_int($segments))
		{
			return cutVideoEqually(Video::find($video_id), $segments);
		}
		else
		{
			return cutVideoAtTimes(Video::find($video_id), $segments);
		}
	}
	
	private function cutVideoEqually($video, $segments)
	{
		try
		{	
			$videoCutter = new CutVideoFFmpegAdapter();
			$videoCutter->cutVideoIntoSegments($video, $segments);
		}
		catch(Exception $e)
		{
			return [
				'error',
				"The request to break the video into segments could not be completed.",
				500
			];
		}

		return [
			'success',
			[],
			200
		];
	}
	
	private function cutVideoAtTimes($video, $times)
	{
		try
		{	
			$videoCutter = new CutVideoFFmpegAdapter();
			$videoCutter->cutVideoByTimes($video, $times);
		}
		catch(Exception $e)
		{
			return $this->apiResponse(
				'error',
				"The request to break the video at specified times could not be completed.",
				500
			);
		}

		return $this->apiResponse(
			'success',
			[],
			200
		);
	}
}

