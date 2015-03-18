<?php

use LangLeap\Videos\Commercial;
use LangLeap\VideoUtilities\MediaUpdaterListener;
use LangLeap\Words\Script;

/**
 * @author David Siekut
 * @author Alan Ly <hello@alan.ly>
 */
class ApiCommercialController extends \BaseController implements MediaUpdaterListener {

	protected $commercials;
	private   $isCreate = false;


	public function __construct(Commercial $commercials)
	{
		$this->commercials = $commercials;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commercials = $this->commercials->all();

		$commercial_array = array();
		foreach($commercials as $commercial)
		{
			$commercial_array[] = $commercial->toResponseArray();
		}
		
		return $this->apiResponse(
			'success',
			$commercial_array
		);


	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$commercial = $this->commercials->newInstance(Input::all());

		if (! $commercial->save())
		{
			return $this->apiResponse('error', $commercial->getErrors(), 500);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag to true so that we generate the correct response.
		$this->isCreate = true;

		// Attempt to update the image.
		return $imageUpdater->update($commercial, Request::instance(), $this);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($commercialId)
	{
		$commercial = $this->commercials->find($commercialId);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.commercial.error', ['id' => $commercialId]),
				404
			);
		}


		return $this->apiResponse("success",$commercial->toResponseArray());
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$commercial = $this->commercials->find($id);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.commercial.error', ['id' => $id]),
				404
			);
		}

		$commercial->fill(Input::get());
		
		if (! $commercial->save())
		{
			return $this->apiResponse('error', $commercial->getErrors(), 500);
		}

		// Create a new updater instance.
		$imageUpdater = App::make('LangLeap\VideoUtilities\MediaImageUpdater');

		// Set the `isCreate` flag to false so that we generate the correct response.
		$this->isCreate = false;

		// Attempt to update the image.
		return $imageUpdater->update($commercial, Request::instance(), $this);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$commercial = $this->commercials->find($id);

		if (! $commercial)
		{
			return $this->apiResponse(
				'error',
				Lang::get('controllers.commercial.error', ['id' => $id]),
				404
			);
		}

		$commercial->videos()->delete();
		$commercial->delete();

		return $this->apiResponse(
			'success',
			Lang::get('controllers.commercial.removed', ['id' => $id]),
			200
		);
	}


	/**
	 * Update the script for this commercial.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateScript($id)
	{
		$commercial = $this->commercials->find($id);
		$video_id = $commercial->videos()->first()->id;
		
		$script = Script::where('video_id', '=', $video_id)->firstOrFail();

		if (! $script)
		{
			return $this->apiResponse('error', "Commercial {$id} not found.", 404);
		}
		
		$script->text = Input::get('text');

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
	*	This method updates timestamps for this video.
	*
	*	@param int $video_id 
	*/
	public function saveTimestamps($id)
	{
		$commercial = $this->commercials->find($id);
		$video = $commercial->videos()->first();

		if (!$video)
		{
			return $this->apiResponse(
				'error',
				"Video {$id} not found.",
				404
			);
		}
		
		$video->timestamps_json = Input::get('text');
		$video->save();
		return $this->apiResponse("success", $video->toResponseArray());
	}


	/**
	 * Handle the event that the media instance has been successfully updated.
	 * @param  mixed  $media the media instance that has been updated.
	 * @return mixed
	 */
	public function mediaUpdated($media)
	{
		// Determine which success HTTP code we should use.
		$code = $this->isCreate ? 201 : 200;

		// Reset our flag.
		$this->isCreate = false;

		return $this->apiResponse('success', $media->toArray(), $code);
	}


	/**
	 * Handle the event that the attempt to update the Media instance results in
	 * validation errors.
	 * @param  mixed $errors a collection of error messages from the validator.
	 * @return mixed
	 */
	public function mediaValidationError($errors)
	{
		return $this->apiResponse('error', $errors, 400);
	}
	
}
