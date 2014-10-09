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
		$show = new Show;

		$show->fill(Input::get());

		if (! $show->save())
		{
			return $this->apiResponse(
				'error',
				$show->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$show->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $showId
	 * @return Response
	 */
	public function show($showId)
	{
		$shows = Show::find($showId);
		
		if (! $shows)
		{
			return $this->apiResponse(
				'error',
				"Show {$showId} not found.",
				404
			);
		}
		
		return $this->apiResponse("success",$shows->toArray());
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
		$show = Show::find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Movie {$id} not found.",
				404
			);
		}

		$show->fill(Input::get());

		if (! $show->save())
		{
			return $this->apiResponse(
				'error',
				$show->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$show->toArray(),
			200
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
		$show = Show::find($id);

		if (! $show)
		{
			return $this->apiResponse(
				'error',
				"Show {$id} not found.",
				404
			);
		}

		$show->seasons()->delete();
		$show->delete();

		return $this->apiResponse(
			'success',
			'Show {$id} has been removed',
			200
		);
	}


}
