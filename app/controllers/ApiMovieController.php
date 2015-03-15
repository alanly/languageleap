<?php

use LangLeap\Videos\Movie;
use LangLeap\Words\Script;

/**
 * @author David Siekut
 * @author Alan Ly <hello@alan.ly>
 */
class ApiMovieController extends \BaseController {

	protected $movies;
	protected $scripts;


	public function __construct(Movie $movies, Script $scripts)
	{
		$this->movies = $movies;
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

		// Check if the input includes an image file, and if it does, check if the
		// upload was successful or not. If both conditions are fine, then we'll
		// handle saving the uploaded image. We would ideally delegate this logic
		// to another class, but for the sake of laziness, we'll just perform the
		// task in-controller.
		if (Input::hasFile('media_image') && Input::file('media_image')->isValid())
		{
			// Perform additional validation on input values.
			$validator = Validator::make(
				Input::get(),
				['media_image' => 'image']
			);

			if ($validator->fails())
			{
				return $this->apiResponse('error', $validator->messages(), 400);
			}

			$splFile = Input::file('media_image');

			// Determine the appropriate file name for the image.
			$filename = get_class($movie)."_{$movie->id}.".$splFile->getExtension();

			if (! App::environment('testing'))
			{
				// Move the image to the appropriate storage location if we're production.
				$splFile = $splFile->move(Config::get('media.paths.img'), $filename);
			}

			if (! $splFile->isReadable())
			{
				return $this->apiResponse('error', ['media_image' => Lang::get('admin.upload.image_store_failed')], 500);
			}

			// Update the movie instance with the image path.
			$movie->image_path = $splFile->getRealPath();
			$movie->save();
		}

		return $this->apiResponse('success', $movie->toArray(), 201);
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
			return $this->apiResponse('error', Lang::get('controllers.movies.movie_error', ['id' => $id]), 404);
		}

		$movie->fill(Input::get());

		if (! $movie->save())
		{
			return $this->apiResponse('error', $movie->getErrors(), 400);
		}

		return $this->apiResponse('success', $movie->toArray(), 200);
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
	
}
