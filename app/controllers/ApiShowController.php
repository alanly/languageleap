<?php
use LangLeap\Videos\Show;
use LangLeap\Videos\Video;
use LangLeap\Words\Script;

class ApiShowController extends \BaseController {

	protected $shows;

	public function __construct(Show $shows)
	{
		$this->shows = $shows;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$shows = Show::all();
	
		return $this->apiResponse("success",$shows->toArray());
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$show = new Show;

		$show->fill(Input::get());

		if (! $show->save())
		{
			return $this->apiResponse(
				'error',
				$show->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$show->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $showId
	 * @return Response
	 */
	public function show($id)
	{
		$shows = Show::find($id);
		
		if (!$shows)
		{
			return $this->apiResponse(
				'error',
				"Show {$id} not found.",
				404
			);
		}
		
		return $this->apiResponse("success", $shows->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$show = Show::find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Movie {$id} not found.",
				404
			);
		}

		$show->fill(Input::get());

		if (! $show->save())
		{
			return $this->apiResponse(
				'error',
				$show->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$show->toArray(),
			200
		);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$show = Show::find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Show {$id} not found.",
				404
			);
		}

		$show->seasons()->delete();
		$show->delete();

		return $this->apiResponse(
			'success',
			'Show {$id} has been removed',
			200
		);
	}
	
	/**
	 * Update the script for this show.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateScript($id)
	{
		$episode = Video::where('viewable_id', '=', Input::get('episode'))->firstOrFail();		
		$script = Script::where('video_id', '=', $episode->id)->firstOrFail();

		if (! $script)
		{
			return $this->apiResponse('error', "Episode {$id} not found.", 404);
		}
		
		$script->text = Input::get('text');

		if (! $script->save())
		{
			return $this->apiResponse(
				'error',
				$script->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$script->toArray(),
			200
		);
	}
	
	/**
	*	This method updates timestamps for this video.
	*
	*	@param int $video_id 
	*/
	public function saveTimestamps($id)
	{
		$episode = Video::where('viewable_id', '=', Input::get('episode'))->firstOrFail();		
		$video = $episode->videos()->first();

		if (!$video)
		{
			return $this->apiResponse(
				'error',
				"Video {$id} not found.",
				404
			);
		}
		
		$video->timestamps_json = Input::get('text');
		$video->save();
		return $this->apiResponse("success", $video->toResponseArray());
	}
	
}
