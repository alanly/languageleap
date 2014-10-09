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

	public static function boot()
	{
		parent::boot();

		static::deleting(function($script)
		{
			$script->video()->delete();
		});
	}

	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');

	}		
}
