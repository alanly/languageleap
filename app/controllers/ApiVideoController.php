<?php

use LangLeap\Levels\Level;
use LangLeap\Videos\Video;
use LangLeap\Words\Script;
use LangLeap\Core\Language;
use LangLeap\WordUtilities\ScriptFile;
use LangLeap\VideoUtilities\VideoFactory;

/**
* @author Thomas Rahn <thomas@rahn.ca>
* @author David Siekut
*/
class ApiVideoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//This is just to show something. This will be replaced with getting all videos for a certain Commercial, Movie or Episode.
		$videos = Video::all();
	
		$videoArray = array();
		
		foreach ($videos as $vid) {
			$videoArray[] = $vid->toResponseArray();
		}

		return $this->apiResponse("success", $videoArray);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @input script 			The text file for the script
	 * @input video 			The video file for the video
	 * @input video_type		The video type (movie, commercial or show)
	 *
	 * @return Response
	 */
	public function store()
	{
		$video = VideoFactory::getInstance()->createVideo(Input::all());
		
		return $this->apiResponse("success",$video->toResponseArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $videoId
	 * @return Response
	 */
	public function show($videoId)
	{
		$video = Video::find($videoId);

		if (! $video)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.videos.error', ['id' => $videoId]),
				404
			);
		}

		$videoArray = array("video" => $video->toResponseArray());

		return $this->apiResponse("success",$videoArray);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$video = Video::find($id);

		if (!$video)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.videos.error', ['id' => $id]),
				404
			);
		}

		$script_file = Input::file('script');
		
		$video_factory = VideoFactory::getInstance();

		$video_factory->setVideo(Input::all(), $video);
		$video_factory->setScript($script_file, $video->id, $video->script()->first());

		return $this->apiResponse("success",$video->toResponseArray());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$video = Video::find($id);

		if(!$video)
			App::abort(404);

		$script = $video->script()->delete();
		$video->delete();

		return $this->apiResponse(
			'success',
			Lang::get('controllers.videos.removed', ['id' => $id]),
			200
		);
	}

	

}
