<?php

use LangLeap\Words\Script;

class ApiScriptController extends \BaseController {

	protected $scripts;

	public function __construct(Script $scripts)
	{
		$this->scripts = $scripts;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$scripts = $this->scripts->all();

		return $this->apiResponse(
			'success',
			$scripts
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
		$script = $this->scripts->find($id);

		if (! $script)
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
		$script = $this->scripts->find($id);

		if (! $script)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.scripts.script_error', ['id' => $id]),
				404
			);
		}

		$script->fill(Input::get());

		if (! $script->save())
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
		$script = $this->scripts->find($id);

		if (! $script)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.scripts.script_error', ['id' => $id]),
				404
			);
		}

		$script->delete();

		return $this->apiResponse(
			'success',
			Lang::get('controllers.scripts.script_removed', ['id' => $id]),
			200
		);
	}
}
