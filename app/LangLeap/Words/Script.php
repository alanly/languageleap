<?php namespace LangLeap\Words;


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
		$this->hasOne('LangLeap\Videos\Video');

	}		
}
