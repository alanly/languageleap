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
			$episode->vdeos()->delete();
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
		$videos = $episode->videos()->get();
		$videos_array = array();
		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray();
		}
		return array(
			'id' => $episode->id,
			'season_id' => $episode->season_id,
			'number' => $episode->number,
			'name' => $episode->name,
			'description' => $episode->description,
			'show_id' => $episode->show_id,
			'videos' => $videos_array,
			'level' => $episode->level->description,
		);
	}

}
