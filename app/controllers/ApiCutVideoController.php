<?php

use LangLeap\Videos\Video;
use LangLeap\CutVideoUtilities\CutVideoAdapter;

class ApiCutVideoController extends BaseController {

	public function postSegments()
	{
		$user = Auth::user();
		if(!$user || !$user->is_admin)
		{
			return $this->apiResponse(
				'error',
				'Must be an administrator to edit videos',
				401
			);
		}
		
		$video_id = Input::get("video_id");
		if(!$video_id)
		{
			return $this->apiResponse(
				'error',
				"Video id is missing.",
				400
			);
		}

		$video = Video::find($video_id);
		if(!$video)
		{
			return $this->apiResponse(
				'error',
				"Video {$video_id} is missing.",
				404
			);
		}

		$segments = Input::get("segments");
		if(!$segments)
		{
			return $this->apiResponse(
				'error',
				"Cut into segments value is missing.",
				400
			);
		}

		return $this->cutVideoEqually($video, $segments);
	}

	private function cutVideoEqually($video, $segments)
	{
		try
		{	
			$videoCutter = new CutVideoAdapter($video);
			$videoCutter->cutVideoIntoSegmets($segments);
		}
		catch(Exception $e)
		{
			return $this->apiResponse(
				'error',
				"The request to break the video into segments could not be completed.",
				500
			);
		}

		return $this->apiResponse(
			'success',
			[]
		);
	}

	public function postTimes()
	{
				$user = Auth::user();
		if(!$user || !$user->is_admin)
		{
			return $this->apiResponse(
				'error',
				'Must be an administrator to edit videos',
				401
			);
		}
		
		$video_id = Input::get("video_id");
		if(!$video_id)
		{
			return $this->apiResponse(
				'error',
				"Video id is missing.",
				400
			);
		}

		$video = Video::find($video_id);
		if(!$video)
		{
			return $this->apiResponse(
				'error',
				"Video {$video_id} is missing.",
				404
			);
		}

		$segments = Input::get("segments");
		if(!$segments)
		{
			return $this->apiResponse(
				'error',
				"Cut into segments value is missing.",
				400
			);
		}

		return $this->cutVideoEqually($video, $segments);
	}
}
