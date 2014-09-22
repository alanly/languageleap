<?php namespace LangLeap\Videos;


class Video extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'videos';
		
	
	/**
	* This function returns the script that is associated with this video
	*/
	public function script()
	{
		return $this->hasOne('Script');
	}
	
	/**
	* This function defines the polymorphic relationships
	*/

	public function viewable()
	{
		return $this->morphTo();
	}	
}
