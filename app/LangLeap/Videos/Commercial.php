<?php namespace LangLeap\Videos;

use LangLeap\Videos\RecommendationSystem\Classifiable;
use LangLeap\Videos\Filtering\Filterable;

class Commercial extends Media implements Classifiable, Filterable {

	public $timestamps = false;


	public static function boot()
	{
		parent::boot();

		static::deleting(function($commercial)
		{
			$commercial->videos()->delete();
		});
	}


	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}


	public function toResponseArray()
	{
		// Retrieve a listing of the associated videos as an array.
		$videos = $this->videos->map(function($video)
		{
			return $video->toResponseArray();
		});

		return [
			'id'          => $this->id,
			'name'        => $this->name,
			'description' => $this->description,
			'image_path'  => $this->image_path,
			'level'       => $this->level->description,
			'videos'      => $videos,
		];
	}

	public function getClassificationAttributes()
	{
		return [
			'type'	=> 'Commercial',
		];
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$filterableAttributes = [
			'name',
			'level',
		];

		$query = Commercial::query();
		$query->select('commercials.id');
		$query->join('levels', 'commercials.level_id', '=', 'levels.id');

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
