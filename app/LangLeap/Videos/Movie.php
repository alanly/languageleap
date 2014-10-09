<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Movie extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'director', 'actor', 'genre'];
	protected $rules      = ['name' => 'required'];

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
