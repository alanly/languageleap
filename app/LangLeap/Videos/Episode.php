<?php namespace LangLeap\Videos;

use LangLeap\Payments\Billable;

/**
 * @author  Thomas Rahn <thomas@rahn.ca>
 * @author  Alan Ly <hello@alan.ly>
 * @author  Dror Ozgaon <dror.ozgaon@gmail.com>
 */
class Episode extends Media implements Billable {

	function __construct($attributes = [])
	{
		$this->timestamps = false;
		$this->fillable = array_merge(parent::getFillable(), ['season_id', 'number']);
		$this->rules = array_merge(parent::getRules(), [
												'season_id'   => 'required|integer',
												'number'      => 'required|integer',
									]);
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
