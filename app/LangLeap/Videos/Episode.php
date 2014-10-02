<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Episode extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'episodes';
	public $timestamps = false;		
	
	/**
	* This function returns the season that this episode belongs to
	*
	*/
	public function season()
	{
		return $this->belongsTo('LangLeap\Videos\Season');
	}
	


	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}	
}
