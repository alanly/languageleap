<?php namespace LangLeap\VideoUtilities;

/**
 * Defines the interface that clients listening to update operations on Media
 * instances must implement.
 * @author Alan Ly <hello@alan.ly>
 */
interface MediaUpdaterListener {

	/**
	 * Handle the event that the media instance has been successfully updated.
	 * @param  mixed  $media the media instance that has been updated.
	 * @return mixed
	 */
	public function mediaUpdated($media);


	/**
	 * Handle the event that the attempt to update the Media instance results in
	 * validation errors.
	 * @param  mixed $errors a collection of error messages from the validator.
	 * @return mixed
	 */
	public function mediaValidationError($errors);
	
}
