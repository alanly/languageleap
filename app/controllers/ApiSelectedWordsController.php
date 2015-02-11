<?php

use LangLeap\Words\Definition;

class ApiSelectedWordsController extends \BaseController {

	public function index()
	{
		$definitions = Definition::all();

		return $this->apiResponse("success", $definitions);
	}
}