<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Movie extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'director', 'actor', 'genre'];

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
