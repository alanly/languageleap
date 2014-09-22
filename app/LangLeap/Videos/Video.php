<?php namespace LangLeap\Videos;


class Video extends Eloquent implements Billable
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
}
