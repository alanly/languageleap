<?php

use LangLeap\Videos\Commercial;

class ApiCommercialController extends \BaseController {

	protected $commercials;

	public function __construct(Commercial $commercials)
	{
		$this->commercials = $commercials;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commercial = Commercial::all();
		

		return $this->apiResponse(
			'success',
			$commercial->toArray()
		);


	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$commercial = new Commercial;

		$commercial->fill(Input::get());

		if (! $commercial->save())
		{
			return $this->apiResponse(
				'error',
				$commercial->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$commercial->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($commercialId)
	{
		$commercial = Commercial::find($commercialId);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				"Commercial {$commercialId} not found.",
				404
			);
		}


		return $this->apiResponse("success",$commercial->toResponseArray($commercial));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$commercial = Commercial::find($id);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				"Commercial {$id} not found.",
				404
			);
		}

		$commercial->fill(Input::get());
		
		if (! $commercial->save())
		{
			return $this->apiResponse(
				'error',
				$commercial->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$commercial->toArray()
		);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$commercial = Commercial::find($id);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				"Commercial {$id} not found.",
				404
			);
		}

		$commercial->videos()->delete();
		$commercial->delete();

		return $this->apiResponse(
			'success',
			'Commercial {$id} has been removed',
			200
		);
	}


}
