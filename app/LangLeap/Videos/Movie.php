<?php namespace LangLeap\Videos;

use LangLeap\Payments\Billable;
use LangLeap\Videos\RecommendationSystem\Classifiable;
use LangLeap\Videos\Filtering\Filterable;

class Movie extends Media implements Billable, Classifiable, Filterable {

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
			'image_path'  => $this->image_path,
			'level'       => $this->level->description,
			'videos'      => $videos,
		];
	}

	public function getClassificationAttributes()
	{
		return [
			'director'	=> explode(',', $this->director),
			'actor'		=> explode(',', $this->actor),
			'genre'		=> $this->genre,
		];
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$filterableAttributes = [
			'name',
			'director',
			'actor',
			'genre',
			'level',
		];

		$query = Movie::query();
		$query->select('movies.id');
		$query->join('levels', 'movies.level_id', '=', 'levels.id');

		foreach ($filterableAttributes as $a)
		{
			if (! isset($input[$a])) continue;

			if ($a == 'level')
				$query->where('levels.description', '=', $input[$a]);
			else
				$query->where($a, 'like', $input[$a] . '%');
		}

		return $query->take($take)->skip($skip)->get();
	}

}
