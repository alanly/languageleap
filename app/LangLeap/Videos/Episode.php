<?php namespace LangLeap\Videos;

use LangLeap\Payments\Billable;
use LangLeap\Videos\RecommendationSystem\Classifiable;

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @author  Alan Ly <hello@alan.ly>
 * @author  Dror Ozgaon <dror.ozgaon@gmail.com>
 */
class Episode extends Media implements Billable, Classifiable {

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


	public function show()
	{
		return $this->season->show;
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
		return [
			'id'            => $this->id,
			'image_path'    => $this->season->show->image_path,
			'season_id'     => $this->season_id,
			'season_number' => $this->season->number,
			'number'        => $this->number,
			'name'          => $this->name,
			'description'   => $this->description,
			'show_id'       => $this->season->show_id,
			'level'         => $this->level->description,
		];
	}

	public function getClassificationAttributes()
	{
		return [
			'director'	=> explode(',', $this->season->show->director),
		];
	}

}
