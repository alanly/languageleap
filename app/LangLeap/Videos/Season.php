<?php namespace LangLeap\Videos;


class Season extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seasons';
		
	
	/**
	* This function returns the show that this season belongs to
	*
	*/
	public function show()
	{
		return $this->belongsTo('Show');
	}
	/**
	* This function returns all the episodes that this season belongs to
	*
	*/
	public function episodes()
	{
		return $this->hasMany('Episode');
	}	
}
