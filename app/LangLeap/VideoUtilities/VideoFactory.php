<?php namespace LangLeap\VideoUtilities;

use LangLeap\Videos\Video;
use LangLeap\Core\Language;
use LangLeap\Words\Script;
use LangLeap\WordUtilities\ScriptFile;
use Config;
use App;

/**
 * Factory that creates Videos based on Input
 *
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class VideoFactory {
 
	private static $instance;
	
	public static function getInstance()
	{
		if (VideoFactory::$instance == null)
		{
			VideoFactory::$instance = new VideoFactory();
		}

		return VideoFactory::$instance;
	}
	
	/**
	 * Return an array with the parameters for BaseController::apiResponse in the same order
	 *
	 * @param  array $input
	 * @return array
	 */
	public function createVideo(array $input)
	{
		$script_file =$input['script'];

		$video = $this->setVideo($input,null);
		$this->setScript($script_file, $video->id);

		return $video;
	}
	

	/**
	 * This method will create a script from a file and a video id
	 *
	 * @param File 		$file 
	 * @param int 		$video_id 
	 * @param Script 	$script
	 */
	public function setScript($file,$video_id, Script $script = null)
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
	 *	@param Input
	 *	@param Video
	 *
	 *	@return Video
	 */
	public function setVideo($input, Video $video = null)
	{

		$lang = Language::find($input['language_id'])->first();
		$file = $input['video'];
		$type = $input['video_type'];

		$ext = $file->getClientOriginalExtension();

		if($video == null)
		{
			$video = new Video;
		}	
		
		$path = "";

		if($type === "commercial")
		{
			$video->viewable_id = $input['commercial'];
			$video->viewable_type = 'LangLeap\Videos\Commercial';
			$path = Config::get('media.paths.videos.commercials');
		}
		elseif($type === "movie")
		{
			$video->viewable_id = $input['movie'];
			$video->viewable_type = 'LangLeap\Videos\Movie';
			$path = Config::get('media.paths.videos.movies');
		}
		elseif($type === "show")
		{
			$video->viewable_id = $input['episode'];
			$video->viewable_type = 'LangLeap\Videos\Episode';
			$path = Config::get('media.paths.videos.shows');
		}

		$video->language_id = $lang->id;
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
