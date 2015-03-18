<?php namespace LangLeap\Videos;

use LangLeap\Videos\RecommendationSystem\Classifiable;
use LangLeap\Videos\Filtering\Filterable;

class Commercial extends Media implements Classifiable, Filterable {

	public $timestamps = false;


	public static function boot()
	{
		parent::boot();

		// Add this model's attributes to the mass-assignable parameter.
		array_push($this->fillable, 'image_path');

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

	public static function getSearchableAttributes()
	{
		return ['name'];
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$searchableAttributes = Commercial::getSearchableAttributes();

		$query = Commercial::query();
		$query->select('commercials.*')
		->join('levels', 'commercials.level_id', '=', 'levels.id')
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
