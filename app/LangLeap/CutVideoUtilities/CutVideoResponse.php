<?php namespace LangLeap\CutVideoUtilities;

use LangLeap\Core\UserInputResponse;
use LangLeap\CutVideoUtilities\CutVideoFFmpegAdapter;
use LangLeap\Accounts\User;
use LangLeap\Videos\Video;
use Lang;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CutVideoResponse implements UserInputResponse
{
	private $cutVideoAdapter;
	
	public function __construct(ICutVideoAdapter $cutVideoAdapter)
	{
		$this->cutVideoAdapter = $cutVideoAdapter;
	}

	public function response(User $user, array $input)
	{
		$video_id = $input['video_id'];
		$segments = $input['segments'];
		
		return $this->cutVideoAtTimes(Video::find($video_id), $segments);
	}
	
	private function cutVideoAtTimes($video, $times)
	{
		$data = [];
		try
		{
			$videos = $this->cutVideoAdapter->cutVideoByTimes($video, $times);
			foreach($videos as $video)
			{
				array_push($data, $video->toResponseArray());
			}
		}
		catch(\Exception $e)
		{
			return ['error', Lang::get('videoutilities.response.error'), 500];
		}

		return ['success', $data, 200];
	}
}

