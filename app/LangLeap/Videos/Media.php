<?php namespace LangLeap\Videos;

use URL;
use LangLeap\Core\Imageable;
use LangLeap\Core\ValidatedModel;

/**
 * @author Dror Ozgaon
 */
abstract class Media extends ValidatedModel implements Imageable {
	
	protected $fillable   = ['name', 'description', 'level_id', 'is_published', 'image_path'];
	protected $attributes = ['level_id' => 1];
	protected $rules      = ['name' => 'required'];


	public function level()
	{
		return $this->belongsTo('LangLeap\Levels\Level');
	}


	/**
	 * Gets a hash value that represents the the media record. The value returned
	 * from this method should not be used in any application that requires a
	 * secure hash.
	 * @return string
	 * @author Alan Ly <hello@alan.ly>
	 */
	public function getHash()
	{
		// Create a string that should uniquely represent the media instance.
		// We'll base it on the table name, concatenated with a '.', followed by the
		// ID value.
		$string = $this->getTable().'.'.$this->getKey();

		// We will use the SHA1 algorithm, as it is less prone to collision attacks,
		// while still being quick enough for mass hashing.
		return hash('sha1', $string);
	}


	public function getImagePath()
	{
		return URL::action('ImageContentController@getImage',
			['model' => class_basename(get_class($this)), 'id' => $this->id]);
	}


	abstract public function videos();

	abstract public function toResponseArray();

}
