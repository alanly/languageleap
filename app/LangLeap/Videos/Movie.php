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
		$videos = $this->videos->map(function($video)
		{
			return $video->toResponseArray();
		});

		return [
			'id'          => $this->id,
			'name'        => $this->name,
			'description' => $this->description,
			'director'    => $this->director,
			'actor'       => $this->actor,
			'genre'       => $this->genre,
			'level'       => $this->level->description,
			'videos'      => $videos,
		];
	}

}
