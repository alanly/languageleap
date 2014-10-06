<?php

use LangLeap\Videos\Video;
use LangLeap\Words\Script;

class ApiVideoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$videos = Video::all();
	
		$videoArray = array();
        
        foreach ($videos as $vid) {
            $videoArray[] = $vid->toResponseArray($vid);
        }

		return $this->apiResponse("success",$videoArray);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @input script 			The text for the script
	 * @input video 			The video for the video
	 * @input video_type		The video type (movie, commercial or show)
	 *
	 * @return Response
	 */
	public function store()
	{
		$script_text = Input::get('script');
		$file = Input::file('video');
		$type = Input::get('video_type');

		$video = new Video;
		$path = "";

		if($type === "commercial")
		{
			$video->viewable_id = Input::get('commercials');
			$video->viewable_type = 'LangLeap\Videos\Commercial';
			$path = Config::get('media.paths.videos.commercials');
		}
		elseif($type === "movie")
		{
			$video->viewable_id = Input::get('movies');;
			$video->viewable_type = 'LangLeap\Videos\Movie';
			$path = Config::get('media.paths.videos.movies');
		}
		elseif($type === "show")
		{
			$video->viewable_id = Input::get('shows');;
			$video->viewable_type = 'LangLeap\Videos\Episode';
			$path = Config::get('media.paths.videos.shows');
		}
		else
		{
			   return App::abort(400);
		}

		$video->path = '';
		$video->save();

		//set the path
		$new_name = base64_encode($video->id);
		$video->path = $path . DIRECTORY_SEPARATOR . $new_name;
		$video_file = $file->move($path,$new_name);
		$video->save();
		
		//Save the script
		$script = new Script;
		$script->text = $script_text;
		$script->video_id = $video->id;
		$script->save();

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
