<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Episode extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $table      = 'episodes';

	public function season()
	{
		return $this->belongsTo('LangLeap\Videos\Season');
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
