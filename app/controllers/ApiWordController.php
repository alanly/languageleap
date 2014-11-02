<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LangLeap\Words\Word;
use LangLeap\Words\ScriptWord;

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
            $wordArray[] = $word->toResponseArray();
        }

		return $this->apiResponse("success",$wordArray);
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
			
			$sw = new ScriptWord;
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
	 * @param  var	$key
	 * @return Response
	 */
	public function show($key)
	{
		$wordArray = array();

		if(gettype($key) == "string")
		{
			$words = Word::where('word', '=', $key)->get();
			foreach ($words as $w) 
			{
				$wordArray[] = $w->toResponseArray();
			}
		}
		elseif(gettype($key) == "integer")
		{
			$w = Word::find($key);
			if($w)
			{
				$wordArray[] = $w->toResponseArray();
			}
		}

		return $this->apiResponse("success",$wordArray);
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

	/**
	 * Get multiple words in one request
	 *
	 */
	public function getMultipleWords()
	{
		$words = Input::get('words');

		if (! is_array($words))
		{
			return $this->apiResponse('error', 'No words were requested.', 400);
		}

		$dbresult = Word::whereIn('word', $words)->get();
		$wordArray = array();
		
		foreach ($dbresult as $word)
		{
			$wordArray[$word->word][] = $word->toResponseArray();
		}

		return $this->apiResponse('success', $wordArray);
	}
}
