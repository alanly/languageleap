<?php

class FileUploadController extends \BaseController {

	public function __construct()
	{

	}

	public function saveMedia()
	{
		$response = 0;

		$type = Input::get('info-radio');
		
		if ($type == "commercial")
		{
			$response = App::make('ApiCommercialController', Input::all())->store();
			
		}
		else if ($type == "show")
		{
			$response = App::make('ApiShowController', Input::all())->store();
			
		}
		else if ($type == "movie")
		{
			$response = App::make('ApiMovieController', Input::all())->store();
			
		}
		
		$id = $response->getData()->data->id;
		App::make('ApiScriptController', Input::all())->store($id);

		$path = '/storage/media/videos/' . $type . 's/';
		Input::file('file')->move(app_path() . $path, $id . '.' . Input::file('file')->getClientOriginalExtension());
		
		
		return View::make('admin.index');
	}

}
