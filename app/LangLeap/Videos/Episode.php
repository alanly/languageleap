<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Episode extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['season_id', 'number', 'name', 'description'];

	public function season()
	{
		return $this->belongsTo('LangLeap\Videos\Season');
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
