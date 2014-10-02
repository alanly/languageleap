<?php

use LangLeap\Videos\Season;
use LangLeap\Videos\Show;

class ApiSeasonController extends \BaseController {

	protected $seasons;
	protected $shows;

	public function __construct(Season $seasons, Show $shows)
	{
		$this->seasons = $seasons;
		$this->shows = $shows;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($showId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', "Show {$showId} not found.", 404);
		}

		$showSeasons = $show->seasons()->get();

		return $this->apiResponse(
			'success',
			['show' => $show->toArray(), 'seasons' => $showSeasons->toArray()]
		);
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
	public function show($showId, $seasonId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', "Show {$showId} not found.", 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				"Season {$seasonId} not found for show {$showId}.",
				404
			);
		}

		return $this->apiResponse(
			'success',
			['show' => $show->toArray(), 'season' => $season->toArray()]
		);
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
		//
	}


}
