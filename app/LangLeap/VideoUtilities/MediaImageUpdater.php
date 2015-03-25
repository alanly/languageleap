<?php namespace LangLeap\VideoUtilities;

use App, Config, Validator;
use Illuminate\Http\Request;
use LangLeap\Core\Imageable;

/**
 * The updater utility class that handles updating a media instance with an
 * appropriate image.
 * @author Alan Ly <hello@alan.ly>
 */
class MediaImageUpdater {

	/**
	 * Defines the parameter name for the media image.
	 */
	const PARAM_NAME = 'media_image';

	/**
	 * The media instance we are updating.
	 * @var LangLeap\Videos\Media
	 */
	private $media;

	/**
	 * The request instance that contains all the relevant input.
	 * @var Illuminate\Http\Request
	 */
	private $request;

	/**
	 * The listener/observer of this class.
	 * @var LangLeap\Videos\MediaUpdaterListener
	 */
	private $listener;


	public function update(Imageable $media, Request $request, MediaUpdaterListener $listener)
	{
		// Get the relevant instances.
		$this->media    = $media;
		$this->request  = $request;
		$this->listener = $listener;

		// Determine if we have an uploaded image and if the upload was valid.
		if ($this->request->hasFile(MediaImageUpdater::PARAM_NAME) 
			&& $this->request->file(MediaImageUpdater::PARAM_NAME)->isValid())
		{
			// If so, then we update the image.
			return $this->updateImage();
		}

		// If there's nothing to update, we will consider this to be a successful 
		// operation as images are optional.
		return $this->listener->mediaUpdated($media);
	}


	private function generateFilename(Imageable $media, $file)
	{
		return get_class($media)."_{$media->id}.".$file->getClientOriginalExtension();
	}


	private function moveFile($file, $filename)
	{
		// If this is the test environment, we shouldn't move the test file.
		// It's not a good approach to things, but it seems like the unit testing
		// capabilities for file uploads is limited.
		if (App::environment('testing')) return $file;

		// Move the image if we're in the production environment.
		$file = $file->move(Config::get('media.paths.img'), $filename);

		// Make sure that our new file instance is readable.
		if (! $file->isReadable())
		{
			// Throw an exception for this server-side issue. It's usually due to
			// a misconfiguration.
			throw new \RuntimeException(Lang::get('admin.upload.image_store_failed'));
		}

		return $file;
	}


	private function updateImage()
	{
		// Ensure the uploaded file is actually an image.
		$validator = Validator::make(
			$this->request->all(),
			['media_image' => 'image']
		);

		// If it isn't, then we exit with the listener's validation error handler.
		if ($validator->fails())
		{
			return $this->listener->mediaValidationError($validator->messages());
		}

		// Get the file instance.
		$file = $this->request->file(MediaImageUpdater::PARAM_NAME);

		// Determine the appropriate file name.
		$filename = $this->generateFilename($this->media, $file);

		// Move the file to the appropriate storage location and get the updated
		// file instance.
		$file = $this->moveFile($file, $filename);

		// Update the media instance with the new path of the image.
		$this->media->image_path = $file->getRealPath();

		// Attempt to save the media instance; if it fails, handle with listener's
		// validation error handler.
		if (! $this->media->save())
		{
			return $this->listener->mediaValidationError($this->media->getErrors());
		}

		// Handle the successful operation with the listener's updated handler.
		return $this->listener->mediaUpdated($this->media);
	}
	
}
