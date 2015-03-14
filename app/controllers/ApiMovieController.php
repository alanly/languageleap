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
		$movie = $this->movies->find($id);
		$video_id = $movie->videos()->first()->id;
		
		$script = Script::where('video_id', '=', $video_id)->firstOrFail();

		if (! $script)
		{
			return $this->apiResponse('error', "Movie {$id} not found.", 404);
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
