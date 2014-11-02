<?php
use LangLeap\Words\Script;

class ApiScriptController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$scripts = Script::all();

		return $this->apiResponse(
			'success',
			$scripts
		);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$script = new Script;

		$script->fill(Input::get());

		if (!$script->save())
		{
			return $this->apiResponse(
				'error',
				$script->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$script->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$script = Script::find($id);

		if (!$script)
		{
			return $this->apiResponse(
				'error',
				"Script {$id} not found.",
				404
			);
		}

		return $this->apiResponse("success", $script->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$script = Script::find($id);

		if (!$script)
		{
			return $this->apiResponse(
				'error',
				"Script {$id} not found.",
				404
			);
		}

		$script->fill(Input::get());

		if (!$script->save())
		{
			return $this->apiResponse(
				'error',
				$script->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$script->toArray(),
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
		$script = Script::find($id);

		if (!$script)
		{
			return $this->apiResponse(
				'error',
				"Script {$id} not found.",
				404
			);
		}

		$script->delete();

		return $this->apiResponse(
			'success',
			'Script {$id} has been removed',
			200
		);
	}
}
