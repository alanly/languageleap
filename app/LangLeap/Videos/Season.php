<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Season extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $table      = 'seasons';
	protected $fillable   = ['show_id', 'number', 'description'];

	public function show()
	{
		return $this->belongsTo('LangLeap\Videos\Show');
	}

	public function episodes()
	{
		return $this->hasMany('LangLeap\Videos\Episode');
	}

}
