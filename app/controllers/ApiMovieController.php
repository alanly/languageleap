<?php
use LangLeap\Videos\Movie;

class ApiMovieController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$movies = Movie::all();

		return $this->apiResponse(
			'success',
			$movies->toArray()
		);

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
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($movieId)
	{
		$movie = Movie::find($id);

		if (! $movie)
		{
			return $this->apiResponse(
				'error',
				"Movie {$movieId} not found.",
				404
			);
		}

		return $this->apiResponse("success",$movie->toResponseArray($movie));
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
		$movie = Movie::find($id);

		if(!$movie)
			App::abort(404);

		$movie->videos()->delete();
		$movie->delete();
	}


}
