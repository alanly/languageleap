<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Commercial extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'commercials';
	public $timestamps = false;
	
	/**
	* This function returns all the videos related to this commercial
	*/
	public function videos()
        {
                return $this->morphMany('LangLeap\Videos\Video','viewable');
        }

}
