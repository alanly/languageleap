<?php namespace LangLeap\Words;

use Eloquent;

class Script extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['text', 'video_id'];
	protected $table      = 'scripts';


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
