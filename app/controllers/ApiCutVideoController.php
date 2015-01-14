<?php

use LangLeap\Videos\Video;
use LangLeap\CutVideoUtilities\CutVideoAdapter;

class ApiCutVideoController extends BaseController {

	public function cutIntoSegments()
	{
		$video_id = Input::get("video_id");
		if(!$video_id)
		{
			return $this->apiResponse(
				'error',
				"Video id is missing.",
				404
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
				404
			);
		}

		$media_id = Input::get("media_id");
		if(!$media_id)
		{
			return $this->apiResponse(
				'error',
				"Media {$media_id} is missing.",
				404
			);
		}

		$segments = Input::get("segments");
		if(!$segments)
		{
			return $this->apiResponse(
				'error',
				"Cut into segments value is missing.",
				404
			);
		}

		return $this->cutVideoEqually($video, $media_id, $segments);
	}

	public function cutVideoEqually($video, $media_id, $segments)
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

		$videoCutter = new CutVideoAdapter($video, $media_id);
		$videoCutter->cutVideoIntoSegmets($segments);
	}

	public function cutAtTimes()
	{

	}
}
