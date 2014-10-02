<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Show extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shows';
	public $timestamps = false;		
	
	/**
	* This function returns all the seasons that are associated with this show
	*
	*/
	public function seasons()
	{
		return $this->hasMany('LangLeap\Videos\Season');
	}	
}
