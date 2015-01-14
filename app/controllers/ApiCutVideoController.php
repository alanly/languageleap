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
		/*
		$ffmpeg = FFMpeg::create();
		$ffmpegVideo = $ffmpeg->open("app\\" . $video->path);

		$ffprobe = FFProbe::create();
		$videoDuration = $ffprobe->format("app\\" . $video->path)->get("duration");

		$ffmpegVideo->filters()->clip(FFMpeg\Coordinate\TimeCode::fromSeconds(1), FFMpeg\Coordinate\TimeCode::fromSeconds(30));
		$ffmpegVideo
		->save(new FFMpeg\Format\Video\X264("libvo_aacenc"), 'video1.mp4');
		*/

		$videoCutter = new CutVideoAdapter($video);
		$videoCutter->cutVideoIntoSegmets($segments);
	}

	public function postTimes()
	{

	}
}
