<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Commercial extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description'];
	
	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
