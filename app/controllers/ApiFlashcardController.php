<?php

use LangLeap\Words\Definition;

class ApiFlashcardController extends \BaseController {

	public function index()
	{
		$definitions = Definition::all();

		return $this->apiResponse("success", $definitions);
	}
}