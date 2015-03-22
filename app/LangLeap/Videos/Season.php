<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;
use LangLeap\Core\PublishedTrait;

class Season extends ValidatedModel implements Billable {

	use PublishedTrait;

	public    $timestamps = false;
	protected $fillable   = ['show_id', 'number', 'description', 'is_published'];
	protected $hidden     = ['episodes'];
	protected $rules      = [
		'show_id' => 'required|integer|exists:shows,id',
		'number'  => 'required|integer',
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($season)
		{
			$season->episodes()->delete();
		});
	}

	public function show()
	{
		return $this->belongsTo('LangLeap\Videos\Show');
	}

	public function episodes()
	{
		return $this->hasMany('LangLeap\Videos\Episode');
	}

}
