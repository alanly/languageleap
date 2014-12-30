<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

class Commercial extends Media {

	function __construct($attributes = [])
	{
		$this->timestamps = false;
		$this->fillable = array_merge(parent::getFillable(), []);
		$this->rules = array_merge(parent::getRules(), []);
		parent::__construct($attributes);
	}

	public static function boot()
	{
		parent::boot();

		static::deleting(function($commercial)
		{
			$commercial->vdeos()->delete();
		});

	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

	public function toResponseArray()
	{
		$comm = $this;
		$videos = $comm->videos()->get();
		$videos_array = array();
		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray();
		}
		return array(
			'id' => $comm->id,
			'name' => $comm->name,
			'description' => $comm->description,
			'videos' => $videos_array,
			'level' => $comm->level->description,
		);
	}
}
