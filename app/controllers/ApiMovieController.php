<?php

use LangLeap\Videos\Media;
use LangLeap\Videos\Movie;
use LangLeap\VideoUtilities\MediaUpdaterListener;
use LangLeap\Words\Script;

/**
 * @author David Siekut
 * @author Alan Ly <hello@alan.ly>
 */
class ApiMovieController extends \BaseController implements MediaUpdaterListener {

	protected $movies;
	protected $scripts;
	private   $isCreate = false;


	public function __construct(Movie $movies, Script $scripts)
	{
		$this->movies  = $movies;
		$this->scripts = $scripts;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->apiResponse(
			'success',
			$this->movies->all()->map(function($movie)
			{
				return $movie->toResponseArray();
			})
		);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$movie = $this->movies->newInstance(Input::get());

		if (! $movie->save())
		{
			return $this->apiResponse('error', $movie->getErrors(), 400);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag to true so that we generate the correct response.
		$this->isCreate = true;

		// Attempt to update the image.
		return $imageUpdater->update($movie, Request::instance(), $this);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$movie = $this->movies->find($id);

		if (!$movie)
		{
			return $this->apiResponse('error', Lang::get('controllers.movies.movie_error', ['id' => $id]), 404);
		}

		return $this->apiResponse("success", $movie->toResponseArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$movie = $this->movies->find($id);

		if (! $movie)
		{
			return $this->apiResponse('error',
				Lang::get('controllers.movies.movie_error', ['id' => $id]), 404);
		}

		$movie->fill(Input::get());

		if (! $movie->save())
		{
			return $this->apiResponse('error', $movie->getErrors(), 400);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag to false so that we generate the correct response.
		$this->isCreate = false;

		// Attempt to update the image.
		return $imageUpdater->update($movie, Request::instance(), $this);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$movie = $this->movies->find($id);

		if (! $movie)
		{
			return $this->apiResponse('error', Lang::get('controllers.movies.movie_error', ['id' => $id]), 404);
		}

		$movie->videos()->delete();
		$movie->delete();

		return $this->apiResponse('success', Lang::get('controllers.movies.movie_deletion', ['id' => $id]), 204);
	}
	
	
	/**
	 * Update the script for this movie.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateScript($id)
	{
		// Attempt to find the specified movie; if it doesn't exist, then we'll
		// fail with an exception.
		$movie = $this->movies->with('videos')->findOrFail($id);

		// Get the ID of the associated video; if there isn't an associated video,
		// then we fail with an exception.
		$video_id = $movie->videos()->firstOrFail()->id;

		// Get the script associated with the video; if there isn't one, we fail
		// with an exception.
		$script = $this->scripts->where('video_id', $video_id)->firstOrFail();
		
		$script->text = Input::get('text');

		if (! $script->save())
		{
			return $this->apiResponse('error', $script->getErrors(), 400);
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
		$movie = Movie::find($id);
		$video = $movie->videos()->first();

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


	/**
	 * Handle the event that the Media instance has been successfully updated.
	 * @param  Media  $media the Media instance that has been updated.
	 * @return mixed
	 */
	public function mediaUpdated(Media $media)
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
