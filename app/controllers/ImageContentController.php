<?php

use Illuminate\Support\Str;
use LangLeap\Core\Imageable;
use LangLeap\Core\FileInfoFactory;

class ImageContentController extends \BaseController {

	private $fileInfo;
	private $str;


	public function __construct(FileInfoFactory $fileInfo, Str $str)
	{
		$this->fileInfo = $fileInfo;
		$this->str = $str;
	}


	public function getImage($model, $id)
	{
		// Get an instance of the model.
		$model = $this->findModel($model);

		if (! $model) App::abort(404);

		// Attempt to get the image path for the model.
		$path = $model->findOrFail($id)->image_path;

		// Create a file info instance from the image path.
		$file = $this->fileInfo->makeInstance($path);

		// If the file is unreadable then abort.
		if (! $file->isReadable()) App::abort(404);

		return Response::download($file);
	}


	/**
	 * Given a base abstract of the video model name, returns a instance of the
	 * abstract. If the abstract cannot be found, then null is returned.
	 * @param  string $abstract
	 * @return mixed
	 */
	private function findModel($abstract)
	{
		// Ensure that the string doesn't contain backslashes.
		if ($this->str->contains($abstract, '\\')) return null;

		// Format the case of the abstract appropriately.
		$abstract = studly_case($abstract);

		// Create the full abstract.
		$abstract = "LangLeap\\Videos\\{$abstract}";

		// Perform this in a try..catch because an exception is thrown when the
		// class cannot be found or instantiated.
		try
		{
			$instance = App::make($abstract);
		}
		catch (Exception $e)
		{
			return null;
		}

		return ($instance instanceof Imageable) ? $instance : null;
	}
	
}
