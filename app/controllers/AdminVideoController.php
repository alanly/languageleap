<?php

use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Episode;
use LangLeap\Words\Script;
class AdminVideoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.video.video');
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
		$script_text = Input::get('script');
		$file = Input::file('video');
	
		$video = new Video;

		//Get the parent object here THIS IS JUST FOR TESTING
		$video->viewable_id = 1;
		$video->viewable_type = 'LangLeap\Videos\Episode';


		$video->path = '';
		$video->save();

		//set the path
		$new_name = base64_encode($video->id);
		$video->path = Config::get('media.paths.videos.shows') . DIRECTORY_SEPARATOR . $new_name;
		$video_file = $file->move(Config::get('media.paths.videos.shows'),$new_name);
		$video->save();
		
		$script = new Script;
		$script->text = $script_text;
		$script->video_id = $video->id;
		$script->save();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
	}


}
