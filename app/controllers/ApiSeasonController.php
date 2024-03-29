<?php

use LangLeap\Videos\Season;
use LangLeap\Videos\Show;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ApiSeasonController extends \BaseController {

	protected $seasons;
	protected $shows;

	public function __construct(Season $seasons, Show $shows)
	{
		$this->seasons = $seasons;
		$this->shows = $shows;

		$this->beforeFilter('auth', ['on' => 'post']);
		$this->beforeFilter('csrf', ['on' => 'post']);
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
			return $this->apiResponse('error', Lang::get('controllers.episodes.error', ['id' => $showId]), 404);
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
	public function store($showId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', Lang::get('controllers.episodes.show_error', ['id' => $showId]), 404);
		}

		$season = $this->seasons->newInstance(Input::get());
		$season->show_id = $showId;

		if (! $season->save())
		{
			return $this->apiResponse(
				'error',
				$season->getErrors(),
				500
			);
		}

		return $this->getSeasonResponse($show, $season, 201);
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
			return $this->apiResponse('error', Lang::get('controllers.episodes.show_error', ['id' => $showId]), 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.season_error', ['seasonId' => $seasonId, 'showId' => $showId]),
				404
			);
		}

		return $this->getSeasonResponse($show, $season);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($showId, $seasonId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', Lang::get('controllers.episodes.show_error', ['id' => $showId]), 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.season_error', ['seasonId' => $seasonId, 'showId' => $showId]),
				404
			);
		}

		// Update the model attributes
		$season->fill(Input::get());

		if (! $season->save())
		{
			return $this->apiResponse(
				'error',
				$season->getErrors(),
				500
			);
		}

		return $this->getSeasonResponse($show, $season);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($showId, $seasonId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', Lang::get('controllers.episodes.show_error', ['id' => $showId]), 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.season_error', ['seasonId' => $seasonId, 'showId' => $showId]),
				404
			);
		}

		if (! $season->delete())
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.season-deletion_error', ['seasonId' => $seasonId, 'showId' => $showId]),
				500
			);
		}

		return $this->apiResponse(
			'success',
			Lang::get('controllers.episodes.season-deletion'),
			204
		);
	}


	/**
	 * Retrieves a formatted API response for a single show's season.
	 *
	 * @param  LangLeap\Videos\Show    $show
	 * @param  LangLeap\Videos\Season  $season
	 * @param  integer                 $code
	 * @return Illuminate\Http\JsonResponse
	 */
	private function getSeasonResponse(Show $show, Season $season, $code = 200)
	{
		return $this->apiResponse(
			'success',
			[
				'show'   => $show,
				'season' => $season,
			],
			$code
		);
	}


}
