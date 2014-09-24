<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Movie extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'movies';
	public $timestamps = false;		
	
	/**
	* This function returns all the videos associated to this movie
	*/
	public function videos()
        {
                return $this->morphMany('LangLeap\Videos\Video','viewable');
        }

}
