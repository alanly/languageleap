<?php

use LangLeap\Videos\Show;
use LangLeap\Videos\Season;
use LangLeap\Videos\Episode;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ApiEpisodeController extends \BaseController {

	protected $shows;
	protected $seasons;
	protected $episodes;

	public function __construct(Show $shows, Season $seasons, Episode $episodes)
	{
		$this->shows = $shows;
		$this->seasons = $seasons;
		$this->episodes = $episodes;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  integer  $showId
	 * @param  integer  $seasonId
	 * @return Response
	 */
	public function index($showId, $seasonId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Show {$showId} could not be found.",
				404
			);
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

		return $this->generateResponse(
			$show,
			$season,
			$season->episodes()->get()
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
	public function show($id)
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
		//
	}


	/**
	 * @param  LangLeap\Videos\Show           $show
	 * @param  LangLeap\Videos\Season         $season
	 * @param  mixed|LangLeap\Videos\Episode  $episode
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function generateResponse(
		Show $show, Season $season, $episodes, $code = 200
	)
	{
		$data = ['show' => $show, 'season' => $season];

		if (is_array($episodes) || $episodes instanceof Illuminate\Database\Eloquent\Collection)
		{
			$data['episodes'] = $episodes;
		}
		else
		{
			$data['episode'] = $episodes;
		}

		return $this->apiResponse('success', $data, $code);
	}


}
