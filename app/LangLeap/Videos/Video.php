<?php namespace LangLeap\Videos;

use Eloquent;

class Video extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['path'];

	public function script()
	{
		return $this->hasOne('LangLeap\Words\Script');
	}

	public function viewable()
	{
		return $this->morphTo();
	}

}