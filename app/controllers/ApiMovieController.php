<?php
use LangLeap\Videos\Movie;

class ApiMovieController extends \BaseController {


	protected $movies;

	public function __construct(Movie $movies)
	{
		$this->movies = $movies;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$movies = Movie::all();

		$movie_array = array();
		foreach($movies as $movie)
		{
			$movie_array[] = $movie->toResponseArray();
		}

		return $this->apiResponse(
			'success',
			$movie_array
		);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$movie = new Movie;

		$movie->fill(Input::get());

		if (! $movie->save())
		{
			return $this->apiResponse(
				'error',
				$movie->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$movie->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$movie = Movie::find($id);

		if (!$movie)
		{
			return $this->apiResponse(
				'error',
				"Movie {$id} not found.",
				404
			);
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
		$movie = Movie::find($id);

		if (! $movie)
		{
			return $this->apiResponse(
				'error',
				"Movie {$id} not found.",
				404
			);
		}

		$movie->fill(Input::get());

		if (! $movie->save())
		{
			return $this->apiResponse(
				'error',
				$movie->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$movie->toArray(),
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
		$movie = Movie::find($id);

		if (! $movie)
		{
			return $this->apiResponse(
				'error',
				"Movie {$id} not found.",
				404
			);
		}

		$movie->videos()->delete();
		$movie->delete();

		return $this->apiResponse(
			'success',
			'Movie {$id} has been removed',
			200
		);
	}
}
