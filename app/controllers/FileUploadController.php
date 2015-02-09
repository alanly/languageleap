<?php
use LangLeap\Levels\Level;

/*
 * @author David Siekut
 * @author Thomas Rahn 
 */
class FileUploadController extends \BaseController {

	public function __construct()
	{

	}

	public function saveMedia()
	{
		$response = 0;

		$type = Input::get('info-radio');
		
		$response = App::make('ApiVideoController')->store();
		
		if ($type == "commercial")
		{
			$response = App::make('ApiCommercialController')->store();
			
		}
		else if ($type == "show")
		{
			$response = App::make('ApiShowController')->store();

			
		}
		else if ($type == "movie")
		{
			$response = App::make('ApiMovieController')->store();
			
		}

		$id = $response->getData()->data->id;
		
		// get all post vars and add on video_id
		$data = Input::all();
		$data['video_id'] = $id;
		
		//save original input
		$original = Request::input();

		//App::make('ApiScriptController')->store();
		// create an internal request
		$request = Request::create('/api/scripts', 'POST', $data);
		// replace the old request with the internal request one
		Request::replace($request->input());
		
		// shoot off the internal request
		$response = Route::dispatch($request);

		//replace the replaced input with the old one
		Request::replace($original);

		// move file to its rightful place
		$path = '/storage/media/videos/' . $type . 's/';
		Input::file('file')->move(app_path() . $path, $id . '.' . Input::file('file')->getClientOriginalExtension());
		

		Session::flash('action.success', true);
		Session::flash('action.message', Lang::get('admin.upload.success'));
		
		return View::make('admin.index')
							->with('levels',LeveL::all());

	}

}
