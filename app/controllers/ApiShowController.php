<?php

use LangLeap\Videos\Show;
use LangLeap\Videos\Episode;
use LangLeap\VideoUtilities\MediaUpdaterListener;

class ApiShowController extends \BaseController implements MediaUpdaterListener {

	protected $shows;
	protected $episodes;
	private   $isCreate = false;


	public function __construct(Show $shows, Episode $episodes)
	{
		$this->shows    = $shows;
		$this->episodes = $episodes;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$shows = $this->shows->all();
	
		return $this->apiResponse('success', $shows->toArray());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$show = $this->shows->newInstance(Input::all());

		if (! $show->save())
		{
			return $this->apiResponse('error', $show->getErrors(), 500);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag so that we generate the correct response.
		$this->isCreate = true;

		// Attempt to update the image.
		return $imageUpdater->update($show, Request::instance(), $this);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $showId
	 * @return Response
	 */
	public function show($id)
	{
		$show = $this->shows->find($id);
		
		if (! $show)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.shows.error', ['id' => $id]),
				404
			);
		}
		
		return $this->apiResponse('success', $show->toArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$show = $this->shows->find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.shows.error', ['id' => $id]),
				404
			);
		}

		$show->fill(Input::get());

		if (! $show->save())
		{
			return $this->apiResponse('error', $show->getErrors(), 500);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag so that we generate the correct response.
		$this->isCreate = false;

		// Attempt to update the image.
		return $imageUpdater->update($show, Request::instance(), $this);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$show = $this->shows->find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.error', ['id' => $id]),
				404
			);
		}

		$show->seasons()->delete();
		$show->delete();

		return $this->apiResponse(
			'success',
			Lang::get('controllers.shows.deletion', ['id' => $id]),
			200
		);
	}


	/**
	 * Update the script for this show.
	 *
	 * Editor's Note (Alan): I'll be frank, I do not quite understand why this
	 * method is in this class at all. `updateScript`? Doesn't that act upon a
	 * specific _episode_? And as of writing this, I believe episodes have their
	 * own individual controller, disregarding the fact that this contains biznit
	 * logic that would very well be much better suited outside the concern of a
	 * response controller. The whole concept of this method is batshit terrible.
	 * Not to mention that (as of this writing) this method has no test coverage.
	 * I'm not kidding, throw in a `return null;` anywhere you want. The covering
	 * test class passes regardless. I'm trying to refactor things, but the idea
	 * of rewriting half the application shouldn't fall under the definition of
	 * "refactoring." I will let git-blame determine who the offending party is.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateScript($id)
	{
		$episode = $this->episodes
		                ->with('videos.scripts')
		                ->findOrFail(Input::get('episode'));

		$script = $episode->videos()->firstOrFail()
		                  ->script()->firstOrFail();
		
		$script->text = Input::get('text');

		if (! $script->save())
		{
			return $this->apiResponse('error', $script->getErrors(), 500);
		}

		return $this->apiResponse('success', $script->toArray(), 200);
	}


	/**
	*	This method updates timestamps for this video.
	*
	*	@param int $video_id 
	*/
	public function saveTimestamps($id)
	{
		$episode = $this->episodes
		                ->with('videos')
		                ->findOrFail(Input::get('episode'));

		$video = $episode->videos()->firstOrFail();
		
		$video->timestamps_json = Input::get('text');

		if (! $video->save())
		{
			return $this->apiResponse('error', $script->getErrors(), 500);
		}
		
		return $this->apiResponse('success', $video->toResponseArray());
	}


	/**
	 * Handle the event that the media instance has been successfully updated.
	 * @param  mixed  $media the media instance that has been updated.
	 * @return mixed
	 */
	public function mediaUpdated($media)
	{
		// Determine which success HTTP code we should use.
		$code = $this->isCreate ? 201 : 200;

		// Reset our flag.
		$this->isCreate = false;

		return $this->apiResponse('success', $media->toArray(), $code);
	}


	/**
	 * Handle the event that the attempt to update the Media instance results in
	 * validation errors.
	 * @param  mixed $errors a collection of error messages from the validator.
	 * @return mixed
	 */
	public function mediaValidationError($errors)
	{
		return $this->apiResponse('error', $errors, 400);
	}
	
}
