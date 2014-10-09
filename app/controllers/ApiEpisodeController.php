<?php

use LangLeap\Videos\Show;
use LangLeap\Videos\Season;
use LangLeap\Videos\Episode;

class ApiEpisodeController extends \BaseController {

	/**
	 * An Episode instance.
	 * 
	 * @var LangLeap\Videos\Episode;
	 */
	protected $episodes;

	public function __construct(Episode $episodes)
	{
		$this->episodes = $episodes;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
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
	 * @param  array|LangLeap\Videos\Episode  $episode
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function generateResponse(
		Show $show, Season $season, $episodes, $code = 200
	)
	{
		$data = ['show' => $show, 'season' => $season];

		if (is_array($episodes))
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
