<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LangLeap\Words\Word;
use LangLeap\Words\Script_Word;

class ApiWordController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$words = Word::all();
	
		$wordArray = array();
        
        foreach ($words as $word) {
            $wordArray[] = $word->toResponseArray($word);
        }

		return $this->apiResponse("success",$wordArray);
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
