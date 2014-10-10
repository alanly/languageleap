<?php
use LangLeap\Videos\Show;

class ApiShowController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$shows = Show::all();
	
		return $this->apiResponse("success",$shows->toArray());
		
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
	public function show($id)
	{
		$shows = Show::find($id);
		
		if (!$shows)
		{
			return $this->apiResponse(
				'error',
				"Show {$id} not found.",
				404
			);
		}
		
		return $this->apiResponse("success", $shows->toArray());
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
		$show = Show::find($id);

		if(!$show)
			App::abort(404);

		$show->delete();

		return $this->apiResponse(
			'success',
			'Show deleted.',
			204
		);
	}
}
