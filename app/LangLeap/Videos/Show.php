<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;
use LangLeap\Videos\Filtering\Filterable;

class Show extends ValidatedModel implements Billable, Filterable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'image_path', 'director'];
	protected $hidden     = ['episodes', 'seasons'];
	protected $rules      = [
		'name'        => 'required',
		'description' => 'required',
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($show)
		{
			$show->seasons()->delete();
		});
	}

	public function episodes()
	{
		return $this->hasManyThrough('LangLeap\Videos\Episode', 'LangLeap\Videos\Season');
	}

	public function seasons()
	{
		return $this->hasMany('LangLeap\Videos\Season');
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$filterableAttributes = [
			'name',
			'director',
		];

		$query = Show::query();
		$query->select('shows.id');

		foreach ($filterableAttributes as $a)
		{
			if (! isset($input[$a])) continue;

			$query->where($a, 'like', $input[$a] . '%');
		}

		return $query->take($take)->skip($skip)->get();
	}

}
