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
	 * @param  int  $showId
	 * @param  int  $seasonId
	 * @return JsonResponse
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
	 * @param  int  $showId
	 * @param  int  $seasonId
	 * @return JsonResponse
	 */
	public function store($showId, $seasonId)
	{
		$show = $this->shows->find($showId);

		if (! $show)
		{
			return $this->apiResponse('error', "Show {$showId} could not be found.", 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error', "Season {$seasonId} not found for show {$showId}.", 404
			);
		}

		$episode = $this->episodes->newInstance(Input::get());
		
		if (! $season->episodes()->save($episode))
		{
			return $this->apiResponse('error', $episode->getErrors(), 400);
		}

		return $this->generateResponse($show, $season, $episode, 201);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $showId
	 * @param  int  $seasonId
	 * @param  int  $episodeId
	 * @return JsonResponse
	 */
	public function show($showId, $seasonId, $episodeId)
	{
		// Retrieve the show, and eagerload season and episode.
		$show = $this->shows
			->with(['seasons' => function($query) use ($seasonId)
			{
				$query->where('id', $seasonId);
			}])
			->with(['episodes' => function($query) use ($episodeId)
			{
				$query->where('episodes.id', $episodeId);
			}])
			->find($showId);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Show {$showId} could not be found.",
				404
			);
		}

		$season = $show->seasons->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				"Season {$seasonId} of show {$showId} could not be found.",
				404
			);
		}

		$episode = $season->episodes->first();

		if (! $episode)
		{
			return $this->apiResponse(
				'error',
				"Episode {$episodeId} of season {$seasonId} for show {$showId} could not be found.",
				404
			);
		}

		return $this->generateResponse($show, $season, $episode);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $showId
	 * @param  int  $seasonId
	 * @param  int  $episodeId
	 * @return JsonResponse
	 */
	public function update($showId, $seasonId, $episodeId)
	{
		// Retrieve the show, and eagerload season and episode.
		$show = $this->shows
			->with(['seasons' => function($query) use ($seasonId)
			{
				$query->where('id', $seasonId);
			}])
			->with(['episodes' => function($query) use ($episodeId)
			{
				$query->where('episodes.id', $episodeId);
			}])
			->find($showId);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Show {$showId} could not be found.",
				404
			);
		}

		$season = $show->seasons->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				"Season {$seasonId} of show {$showId} could not be found.",
				404
			);
		}

		$episode = $season->episodes->first();

		if (! $episode)
		{
			return $this->apiResponse(
				'error',
				"Episode {$episodeId} of season {$seasonId} for show {$showId} could not be found.",
				404
			);
		}

		$episode->fill(Input::get());

		if (! $episode->save())
		{
			return $this->apiResponse('error', $episode->getErrors(), 400);
		}

		return $this->generateResponse($show, $season, $episode);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return JsonResponse
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

		if ($episodes instanceof Episode)
		{
			$data['episode'] = $episodes;
		}
		else
		{
			$data['episodes'] = $episodes;
		}

		return $this->apiResponse('success', $data, $code);
	}


}
