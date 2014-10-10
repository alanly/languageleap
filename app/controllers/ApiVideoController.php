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
            $videoArray[] = $vid->toResponseArray();
        }

		return $this->apiResponse("success",$videoArray);
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
		$script_file = Input::file('script');
		$file = Input::file('video');
		$type = Input::get('video_type');

		$video = $this->setVideo($file,$type,null);
		$this->setScript($script_file, $video->id);

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
				"Video {$videoId} not found.",
				404
			);
		}

		$videoArray = array(
			"video" => $video->toResponseArray());

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

		if (! $video)
		{
			return $this->apiResponse(
				'error',
				"Video {$id} not found.",
				404
			);
		}

		$script_file = Input::file('script');
		$file = Input::file('video');
		$type = Input::get('video_type');

		
		$video = $this->setVideo($file,$type, $video);
		
		$this->setScript($script_file, $video->id,$video->script()->first());

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
			'Video {$id} has been removed',
			200
		);
	}

	/**
	*	This method will create a script from a file and a video id
	*
	*	@param File $file 
	*	@param int $video_id 
	*/

	private function setScript($file,$video_id, Script $script = null)
	{
		if($script == null)
		{
			$script = new Script;
		}

		$script_text = ScriptFile::retrieveText($file);
		$script->text = $script_text;
		$script->video_id = $video_id;
		$script->save();
	}

	/**
	*	This function is used to take the file and type that is sent from the user to create/set a video object
	*
	*	@param File
	*	@param String
	*	@param Video
	*
	*	@return Video
	*/
	private function setVideo($file, $type, Video $video = null)
	{
		$ext = $file->getClientOriginalExtension();
		if($video == null)
		{
			$video = new Video;
		}	
		
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

		$video->path = '';
		$video->save();
		
		//set the path
		$new_name = $video->id . "." . $ext;
		$video->path = $path . DIRECTORY_SEPARATOR . $new_name;

		if (!App::environment('testing')) {
			$video_file = $file->move($path,$new_name);
		}
		$video->save();

		return $video;
	}



}
