<?php

use LangLeap\Videos\RecommendationSystem\Recommendatore;

class ApiRecommendedVideosController extends \BaseController {

	protected $recommendatore;

	public function __construct(Recommendatore $recommendatore)
	{
		// Define the Recommendatore dependency.
		$this->recommendatore = $recommendatore;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (! Auth::check())
		{
			return $this->apiResponse(
				'error',
				'User not logged in.',
				401
			);
		}

		$this->recommendatore->generate(Auth::user());
		//$recommendations = $this->recommendatore->fetch(Auth::user(), 10);

		//dd($recommendations);

	}

}
