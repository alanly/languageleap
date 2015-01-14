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

		$mediaType = Input::get("mediaType");
		if(!$mediaType)
		{
			return $this->apiResponse(
				'error',
				"Media type is missing.",
				400
			);
		}

		$media_id = Input::get("media_id");
		if(!$media_id)
		{
			return $this->apiResponse(
				'error',
				"Media {$media_id} is missing.",
				400
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

		return $this->cutVideoEqually($video, $media_id, $mediaType, $segments);
	}

	private function cutVideoEqually($video, $media_id, $mediaType, $segments)
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

		$videoCutter = new CutVideoAdapter($video, $media_id, $mediaType);
		$videoCutter->cutVideoIntoSegmets($segments);
	}

	public function postTimes()
	{

	}
}
