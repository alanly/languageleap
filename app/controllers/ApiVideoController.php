<?php

use LangLeap\Videos\Video;
use LangLeap\Words\Script;
use LangLeap\Words\Script_Word;
use LangLeap\WordUtilities\ScriptFile;
/**
* @author Thomas Rahn <thomas@rahn.ca>
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
		$script_text = Input::file('script');
		$file = Input::file('video');
		$type = Input::get('video_type');

		//open file of script
		//read it
		//save it in DB
		$value = ScriptFile::retrieveText($file);


		$ext = $file->getClientOriginalExtension();

		$video = new Video;
		$path = "";

		if($type === "commercial")
		{
			$video->viewable_id = Input::get('commercial');
			$video->viewable_type = 'LangLeap\Videos\Commercial';
			$path = Config::get('media.paths.videos.commercials');
		}
		elseif($type === "movie")
		{
			$video->viewable_id = Input::get('movie');;
			$video->viewable_type = 'LangLeap\Videos\Movie';
			$path = Config::get('media.paths.videos.movies');
		}
		elseif($type === "show")
		{
			$video->viewable_id = Input::get('episode');;
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
		$new_name = $video->id . "." . $ext;
		$video->path = $path . DIRECTORY_SEPARATOR . $new_name;
		$video_file = $file->move($path,$new_name);
		$video->save();
		
		//Save the script
		$script = new Script;
		$script->text = $script_text;
		$script->video_id = $video->id;
		$script->save();
		
		Session::put('script', $script->text);
		Session::put('script_id', $script->id);
		
		return Redirect::to('admin/new/script');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $videoId
	 * @return Response
	 */
	public function show($videoId)
	{
		$video = Video::find($id);

		if (! $video)
		{
			return $this->apiResponse(
				'error',
				"Video {$videoId} not found.",
				404
			);
		}

		$videoArray = array(
			"video" => $video->toResponseArray($video));

		return $this->apiResponse("success",$videoArray);

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
		$video = Video::find($id);

		if(!$video)
			App::abort(404);

		$script = $video->script()->delete();
		$video->delete();
	}


}
