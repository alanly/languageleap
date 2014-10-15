<?php

use LangLeap\Words\Word;

/**
 * @author John Di Girolamo & Dror Ozgaon 
 */
class ApiFlashcardController extends \BaseController {

	//protected $flashcards;
	protected $words;

	public function __construct(Word $words)
	{
		$this->$words = $words;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($wordId)
	{
		$word = Word::find($wordId);
		

		return $this->apiResponse(
			'success',
			$word->toResponseArray()
		);


	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$word = new Word;

		$word->fill(Input::get());

		if (! $word->save())
		{
			return $this->apiResponse(
				'error',
				$word->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$word->toArray(),
			201
		);	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($wordId)
	{
		$word = Word::find($wordId);

		if (! $word)
		{
			return $this->apiResponse(
				'error',
				"Word {$wordId} not found.",
				404
			);
		}


		return $this->apiResponse("success",$word->toResponseArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$word = Word::find($id);

		if (! $word)
		{
			return $this->apiResponse(
				'error',
				"Word {$id} not found.",
				404
			);
		}

		$word->fill(Input::get());
		
		if (! $word->save())
		{
			return $this->apiResponse(
				'error',
				$word->getErrors(),
				500
			);
		}

		return $this->apiResponse(
			'success',
			$word->toArray()
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
		$word = Word::find($id);

		if (! $word)
		{
			return $this->apiResponse(
				'error',
				"Word {$id} not found.",
				404
			);
		}

		$word->delete();

		return $this->apiResponse(
			'success',
			'Word {$id} has been removed',
			200
		);
	}


}