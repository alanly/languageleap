<?php namespace LangLeap\Videos;

use LangLeap\Payments\Billable;

class Movie extends Media implements Billable {

	public $timestamps = false;

	function __construct(array $attributes = [])
	{
		// Add this model's attributes to the mass-assignable parameter.
		array_push($this->fillable, 'director', 'actor', 'genre');

		/*
		 * Pass any construction parameters to the base constructor.
		 * This needs to be performed last because the `fillable` paramter is set
		 * above.
		 */
		parent::__construct($attributes);
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

	public function toResponseArray()
	{
		$movie = $this;
		$videos = $movie->videos()->get();
		$videos_array = array();
		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray();
		}
		return array(
			'id' => $movie->id,
			'name' => $movie->name,
			'description' => $movie->description,
			'director' => $movie->director,
			'actor' => $movie->actor,
			'genre' => $movie->genre,
			'level' => $movie->level->description,
			'videos' => $videos_array,
		);
	}

}
