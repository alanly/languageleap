<?php namespace LangLeap\VideoUtilities;

use LangLeap\Videos\Media;

/**
 * Defines the interface that clients listening to update operations on Media
 * instances must implement.
 * @author Alan Ly <hello@alan.ly>
 */
interface MediaUpdaterListener {

	/**
	 * Handle the event that the Media instance has been successfully updated.
	 * @param  Media  $media the Media instance that has been updated.
	 * @return mixed
	 */
	public function mediaUpdated(Media $media);


	/**
	 * Handle the event that the attempt to update the Media instance results in
	 * validation errors.
	 * @param  mixed $errors a collection of error messages from the validator.
	 * @return mixed
	 */
	public function mediaValidationError($errors);
	
}
