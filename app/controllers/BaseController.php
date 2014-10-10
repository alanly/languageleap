<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Create a response intended for the JSON API.
	 *
	 * @param string  $status
	 * @param mixed   $data
	 * @param integer $code
	 * @return Illuminate\Http\JsonResponse
	 */
	protected function apiResponse($status, $data, $code = 200)
	{
		return Response::json(
			[
				'status' => $status,
				'data'   => $data,
			],
			$code
		);
	}
	
}
