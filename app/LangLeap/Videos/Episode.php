<?php namespace LangLeap\Videos;


class Episode extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'episodes';
		
	
	/**
	* This function returns the season that this episode belongs to
	*
	*/
	public function season()
	{
		return $this->belongsTo('Season');
	}
	


	public function videos()
	{
		return $this->hasMany('Video');
	}	
}
