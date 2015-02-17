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

	public static function getSearchableAttributes()
	{
		return ['name', 'director', 'actor', 'genre'];
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$searchableAttributes = Movie::getSearchableAttributes();

		$query = Movie::query();
		$query->select('movies.*')
		->join('levels', 'movies.level_id', '=', 'levels.id')
		->where(function($q) use ($input, $searchableAttributes)
		{
			foreach ($searchableAttributes as $a)
			{
				if (! isset($input[$a])) continue;

				$q->orWhere($a, 'like', '%' . $input[$a] . '%');
			}
		})
		->where(function($q) use ($input)
		{
			if (! isset($input['level'])) return;

			$q->where('levels.description', '=', $input['level']);
		});

		return $query->take($take)->skip($skip)->get();
	}

}
