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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
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
		$commercial = Commercial::find($id);

		if(!$commercial)
			App::abort(404);
		$commercial->videos()->delete();
		$commercial->delete();
	}


}
