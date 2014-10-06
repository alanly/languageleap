<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LangLeap\Videos\Video;
use LangLeap\Videos\Commercial;
use LangLeap\Videos\Movie;
use LangLeap\Videos\Episode;
use LangLeap\Words\Script;
use LangLeap\Words\Word;
use LangLeap\Words\Script_Word;
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
		
		return View::make('admin.video.script', array('script' => $script->text, 'script_id' => $script->id));
	}
	
	/**
	 * Store only words with definitions
	 * 
	 */
	public function storeDefinitions()
	{
		$definitions = Input::get('definitions');
		$script_id = Input::get('script_id');
		$wordPosition = 1;
		
		foreach($definitions as $word => $fields)
		{
			if(!$fields['def']) // If the definition is blank, skip the word
			{
				continue;
			}
			
			$w; // var to store the word
			try
			{
				$w = Word::where('word', '=', $word)->where('definition', '=', $fields['def'])->firstOrFail(); // Should only have one result
			}
			catch(ModelNotFoundException $e) // If the word was not found, create a new word
			{
				$w = new Word;
				$w->word = $word;
				$w->pronouciation = $fields['pronun'];
				$w->definition = $fields['def'];
				$w->full_definition = $fields['full_def'];
				$w->save();
			}
			
			$sw = new Script_Word;
			$sw->script_id = $script_id;
			$sw->word_id = $w->id;
			$sw->position = $wordPosition++;
			$sw->save();
		}
		
		return Redirect::to('admin');
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
