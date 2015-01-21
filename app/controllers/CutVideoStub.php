<?php

use LangLeap\Videos\Video;

class CutVideoStub extends \BaseController
{
	public function postIndex()
	{
		$videoToCut = Video::first();
		$videoSegments = array();
		
		$segments = Input::get('segments');
		
		for ($i = 0; $i < count($segments); $i++)
		{
			$videoSegments[] = $videoToCut->toResponseArray();
		}
		
		return $this->apiResponse("success", $videoSegments);
	}
}