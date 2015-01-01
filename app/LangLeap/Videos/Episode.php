<?php namespace LangLeap\Videos;

use LangLeap\Payments\Billable;

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @author  Alan Ly <hello@alan.ly>
 * @author  Dror Ozgaon <dror.ozgaon@gmail.com>
 */
class Episode extends Media implements Billable {

	public $timestamps = false;

	function __construct(array $attributes = [])
	{
		// Add this model's attributes to the mass-assignable parameter.
		array_push($this->fillable, 'season_id', 'number');

		// Add the necessary rules for this model's specific attributes.
		$this->rules['season_id'] = 'required|integer';
		$this->rules['number']    = 'required|integer';

		/*
		 * Pass any construction parameters to the base constructor.
		 * This needs to be performed last because the `fillable` paramter is set
		 * above.
		 */
		parent::__construct($attributes);
	}

	public static function boot()
	{
		parent::boot();

		static::deleting(function($episode)
		{
			$episode->videos()->delete();
		});

	}

	public function season()
	{
		return $this->belongsTo('LangLeap\Videos\Season');
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

	public function toResponseArray()
	{
		$episode = $this;
		return array(
			'id' => $episode->id,
			'season_id' => $episode->season_id,
			'number' => $episode->number,
			'name' => $episode->name,
			'description' => $episode->description,
			'show_id' => $episode->season->show_id,
			'level' => $episode->level->description,
		);
	}

}
