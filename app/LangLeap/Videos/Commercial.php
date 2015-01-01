<?php namespace LangLeap\Videos;

class Commercial extends Media {

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
			'level' => $comm->level->description,
			'videos' => $videos_array,
		);
	}
}
