<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;
class Season extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seasons';
	public $timestamps = false;		
	
	/**
	* This function returns the show that this season belongs to
	*
	*/
	public function show()
	{
		return $this->belongsTo('LangLeap\Videos\Show');
	}
	/**
	* This function returns all the episodes that this season belongs to
	*
	*/
	public function episodes()
	{
		return $this->hasMany('LangLeap\Videos\Episode');
	}	
}
