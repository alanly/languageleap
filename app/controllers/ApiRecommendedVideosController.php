<?php

use LangLeap\Videos\RecommendationSystem\Recommendatore;

class ApiRecommendedVideosController extends \BaseController {

	private $defaultTake = 5;

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
		$take = Input::get('take', $this->defaultTake);

		if (! Auth::check())
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.recommended.not-logged_error'),
				401
			);
		}

		$this->recommendatore->generate(Auth::user());
		$recommendations = $this->recommendatore->fetch(Auth::user(), $take);

		return $this->apiResponse(
			'success',
			$this->generateResponseData($recommendations)
		);		
	}

	public function generateResponseData($recommendations)
	{
		$responseData = array();
		foreach ($recommendations as $r)
		{
			$media = $r->getMedia();

			$response = $media->toResponseArray();
			$response['type'] = get_class($media);

			$responseData[] = $response;
		}
		
		return $responseData;
	}

}
