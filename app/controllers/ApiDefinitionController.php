<?php

use LangLeap\Words\Definition;

class ApiDefinitionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$definitions = Definition::all();

		$arr = array();
		foreach ($definitions as $def)
		{
			$arr[] = $def->toResponseArray();
		}

		return $this->apiResponse("success", $arr);
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$def = Definition::find($id);

		if (!$def)
		{
			return $this->apiResponse(
				'error',
				"Definition {$id} not found.",
				404
			);
		}

		return $this->apiResponse("success", $def->toResponseArray());
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$def = new Definition;

		$def->fill(Input::get());

		if (!$def->save())
		{
			return $this->apiResponse(
				'error',
				$def->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$def->toArray(),
			201
		);	
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$def = Definition::find($id);

		if (!$def)
		{
			return $this->apiResponse(
				'error',
				"Definition {$id} not found.",
				404
			);
		}

		$def->fill(Input::get());

		if (!$def->save())
		{
			return $this->apiResponse(
				'error',
				$def->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$def->toArray(),
			200
		);
	}
	
}