<?php namespace LangLeap\Words;

use Eloquent;

class Script extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'scripts';
	public $timestamps = false;

	public function video()
	{
		$this->belongsTo('LangLeap\Videos\Video');

	}		
}
