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
				Lang::get('controllers.recommended.not-logged_error'),
				401
			);
		}

		$this->recommendatore->generate(Auth::user());
		$recommendations = $this->recommendatore->fetch(Auth::user(), 10);

		return $this->apiResponse(
			'success',
			$this->generateResponseData($recommendations)
		);		
	}

	public function generateResponseData($recommendations)
	{
		$responseData = array();
		foreach ($recommendations as $recommendation)
		{
			array_push($responseData, $recommendation->getMedia()->toResponseArray());
		}
		
		return $responseData;
	}

}
