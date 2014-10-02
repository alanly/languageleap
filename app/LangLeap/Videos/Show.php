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
	public function toResponseArray()
	{
		$s = $this;
		$show = array(
			'id' => $s->id,
			'name' => $s->name,
			'description' => $s->description,
			'image_path' => $s->image_path,
			'director' => $s->director
		);


		return $show;
	}
}
