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

	public function toResponseArray($movie)
	{
		$videos = $movie->videos()->get();
		$videos_array = array();
		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray($video);
		}
		return array(
			'id' => $movie->id,
			'name' => $movie->name,
			'description' => $movie->description,
			'director' => $movie->director,
			'actor' => $movie->actor,
			'genre' => $movie->genre,
			'videos' => $videos_array,
		);
	}

}
