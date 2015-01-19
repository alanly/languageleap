<?php

use LangLeap\Videos\Video;
use LangLeap\CutVideoUtilities\CutVideoResponse;
use LangLeap\CutVideoUtilities\CutVideoValidation;
use LangLeap\CutVideoUtilities\CutVideoLibavAdapter;

class ApiCutVideoController extends BaseController {

	/**
	 * Post video_id and integer of amount of segments to cut video by.
	 * Responds with a JSON of the new videos.
	 */
	public function postSegments()
	{
		$cutVideo = new CutVideoValidation(new CutVideoResponse(new CutVideoLibavAdapter()));
		$response = $cutVideo->response(Auth::user(), Input::all());
		return $this->apiResponse(
			$response[0], $response[1], $response[2]
		);
	}
}
