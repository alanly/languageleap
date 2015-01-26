<?php

use LangLeap\Accounts\ViewingHistory;

class ApiViewingHistoryController extends \BaseController {
	
	/**
	 * This function will return the current time for the video he is currently watching
	 */
	public function getIndex()
	{
		//User should be logged in
		$user = Auth::user();

		$video_id = Input::get("video_id");

		if (! $video_id)
		{
			return $this->apiResponse(
				'error',
				"Video {$video_id} does not exists",
				404
			);
		}

		return $this->generateResponse($user->id, $video_id);
	}

	public function postIndex()
	{
		$user = Auth::user();

		$video_id = Input::get("video_id");

		if (! $video_id)
		{
			return $this->apiResponse(
				'error',
				"Video {$video_id} does not exists",
				404
			);
		}

		$current_time = Input::get('current_time');

		$history = ViewingHistory::where('user_id', $user->id)
		                         ->where('video_id', $video_id)
		                         ->get()
		                         ->first();

		$history->fill(Input::get());

		if (! $history->save())
		{
			return $this->apiResponse('error', $history->getErrors(), 400);
		}

		return $this->apiResponse(
			'success',
			"History Updated successfully",
			200
		);
	}

	/*
	 * This function will take the user id and the video id and return the appropriate viewing history
	 * 
	 * @param int User id
	 * @param int video id
	 * @return JSON json response 
	 */
	protected function generateResponse($user_id, $video_id)
	{
		$history = ViewingHistory::where('user_id', $user_id)->where('video_id', $video_id)->get()->first();

		if (! $history)
		{
			//There is no history of this user viewing this video, current time = 0
			return $this->apiResponse(
				'success',
				["current_time" => 0],
				200
			);
		}

		return $this->apiResponse(
			'success',
			["current_time" => $history->current_time],
			200
		);
	}

}
