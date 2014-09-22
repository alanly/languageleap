<?php namespace LangLeap\Videos;


class Movie extends Eloquent implements Billable
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'movies';
		
	
	/**
	* This function returns all the videos associated to this movie
	*/
	public function videos()
        {
                return $this->morphMany('Video','viewable');
        }

}
