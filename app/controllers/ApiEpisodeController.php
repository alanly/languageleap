<?php

use Illuminate\Support\Collection;
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
				Lang::get('controllers.episodes.show_error',  ['showId' => $showId]),
				404
			);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.season_error',  ['seasonId' => $seasonId,  'showId' => $showId]),
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
			return $this->apiResponse('error', Lang::get('controllers.episodes.show_error', ['showId' => $showId]), 404);
		}

		$season = $show->seasons()->where('id', $seasonId)->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error', Lang::get('controllers.episodes.season_error', ['seasonId' => $seasonId,  'showId' => $showId]), 404
			);
		}
		
		$episode = $this->episodes->newInstance(Input::get());
		
		if (! $season->episodes()->save($episode))
		{
			return $this->apiResponse('error', $episode->getErrors(), 400);
		}

		/*
		 * Need to retrieve the saved model from the database in case the `level_id`
		 * wasn't defined in the input data. The default `level_id` is specified by
		 * the table schema. Saving doesn't seem to sync the instance data with the 
		 * persisted data. So here we are.
		 */
		$episode = $this->episodes->find($episode->id);

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
				Lang::get('controllers.episodes.show_error', ['showId' => $showId]),
				404
			);
		}

		$season = $show->seasons->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.show-season_error', ['seasonId' => $seasonId,  'showId' => $showId]),
				404
			);
		}

		$episode = $show->episodes->first();

		if (! $episode)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.episode_error', ['episodeId' => $episodeId, 'seasonId' => $seasonId, 'showId' => $showId]),
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
				Lang::get('controllers.episodes.show_error', ['showId' => $showId]),
				404
			);
		}

		$season = $show->seasons->first();

		if (! $season)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.show-season_error', ['seasonId' => $seasonId,  'showId' => $showId]),
				404
			);
		}

		$episode = $season->episodes->first();

		if (! $episode)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.episodes.episode_error', ['episodeId' => $episodeId, 'seasonId' => $seasonId, 'showId' => $showId]),
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
	 * @param  int  $showId
	 * @param  int  $seasonId
	 * @param  int  $episodeId
	 * @return JsonResponse
	 */
	public function destroy($showId, $seasonId, $episodeId)
	{
		// Attempt to retrieve the episode.
		$episode = $this->episodes->findOrFail($episodeId);

		// Get a reference to the associated show.
		$show = $episode->show();

		// Make sure that we are operating against the correct episode instance.
		if ($show->id != $showId || $episode->season_id != $seasonId)
		{
			return $this->apiResponse(
				'error',
				Lang::get(
					'controllers.episodes.episode_error',
					['episodeId' => $episodeId, 'seasonId' => $seasonId, 'showId' => $showId]
				),
				404
			);
		}

		if (! $episode->delete())
		{
			return $this->apiResponse(
				'error',
				Lang::get(
					'controllers.episodes.episode-deletion_error',
					['episodeId' => $episodeId, 'seasonId' => $seasonId, 'showId' => $showId]
				),
				500
			);
		}

		return $this->apiResponse('success', 'Episode deleted.', 204);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return JsonResponse
	 */
	public function showEpisode($id)
	{
		
		$episode = $this->episodes->find($id);

		if (! $episode)
		{
			return $this->apiResponse(
				'error',
				"Episode {$id} could not be found.",
				404
			);
		}

		return $this->generateCustomizedResponse($episode);
	}

	/**
	 * @param  LangLeap\Videos\Show           $show
	 * @param  LangLeap\Videos\Season         $season
	 * @param  mixed|LangLeap\Videos\Episode  $episodes
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function generateResponse(Show $show, Season $season, $episodes, $code = 200)
	{
		$data = ['show' => $show, 'season' => $season];

		if ($episodes instanceof Episode)
		{
			$data['episode'] = $episodes->toResponseArray();
			//$data['videos'] = $episodes->videos;
			$data['videos'] = [];

			foreach ($episodes->videos as $video) {
				array_push($data['videos'], $video->toResponseArray());
			}

		}
		elseif ($episodes instanceof Collection)
		{
			$data['episodes'] = $episodes->map(function($episode)
			{
				return $episode->toResponseArray();
			});
		}
		elseif (is_array($episodes))
		{
			$data['episodes'] = array_map(function($episode)
				{
					return $episode->toResponseArray();
				},
				$episodes
			);
		}

		return $this->apiResponse('success', $data, $code);
	}


	/**
	 * @param  LangLeap\Videos\Episode       $episodes
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function generateCustomizedResponse($episode, $code = 200)
	{
		$data['episode'] = $episode->toResponseArray();
		$data['videos'] = $episode->videos;
		
		return $this->apiResponse('success', $data, $code);
	}

}
