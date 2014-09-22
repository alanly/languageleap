<?php namespace LangLeap\Videos;


class Commercial extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'commercials';
		
	
	/**
	* This function returns all the videos related to this commercial
	*/
	public function videos()
	{
		return $this->hasMany('Video');
	}	
}
