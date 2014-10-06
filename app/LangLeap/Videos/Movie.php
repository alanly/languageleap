<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Movie extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $table      = 'movies';

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}
	
	public function toResponseArray()
	{
		$m = $this;
		$movie = array(
			'id' => $m->id,
			'name' => $m->name,
			'description' => $m->description,
			'director' => $m->director,
			'actor' => $m->actor,
			'genre' => $m->genre,
		);
		
		return $movie;
	}
}
