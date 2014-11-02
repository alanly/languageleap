<?php

use LangLeap\Words\Script;
use LangLeap\Videos\Video;

/**
 * @author  ThomasRahn <thomas@rahn.ca>
 */
class ScriptContentController extends \BaseController {

	protected $scripts;


	public function __construct(Script $scripts)
	{
		// Get reference for the database repository instance.
		$this->scripts = $scripts;
	}


	/**
	 * Return the Script
	 * 
	 * @param  int $id 
	 */
	public function getScript($id)
	{

		$video = Video::find($id);

		if(! $video)
		{
			return $this->apiResponse('error', "There is no script associated with this video.", 404);
		}

		$script = $video->script()->get();

		if (! $script)
		{
			return $this->apiResponse('error', "There is no script associated with this video.", 404);
		}


		return $this->apiResponse(
			'success',
			$script->toArray(),
			201
		);	
	}
}
