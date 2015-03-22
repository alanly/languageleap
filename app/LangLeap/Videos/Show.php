<?php namespace LangLeap\Videos;

use URL;
use LangLeap\Core\Imageable;
use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;
use LangLeap\Videos\Filtering\Filterable;
use LangLeap\Core\PublishedTrait;

class Show extends ValidatedModel implements Billable, Filterable, Imageable {

	use PublishedTrait;

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'image_path', 'director', 'actor', 'genre', 'is_published'];
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

	public function toArray()
	{
		$serialized = parent::toArray();

		$serialized['image_path'] = URL::action('ImageContentController@getImage',
			['model' => class_basename(get_class($this)), 'id' => $this->id]);

		return $serialized;
	}

	public static function getSearchableAttributes()
	{
		return ['name', 'director'];
	}

	public static function filterBy($input, $take, $skip = 0)
	{
		$searchableAttributes = Show::getSearchableAttributes();

		$query = Show::query();
		$query->select('shows.*')
		      ->where(function($q) use ($input, $searchableAttributes)
		{
			foreach ($searchableAttributes as $a)
			{
				if (! isset($input[$a])) continue;

				$q->orWhere($a, 'like', '%' . $input[$a] . '%');
			}
		});

		return $query->take($take)->skip($skip)->get();
	}

}
