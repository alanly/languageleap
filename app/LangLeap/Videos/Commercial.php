<?php namespace LangLeap\Videos;

use LangLeap\Videos\RecommendationSystem\Classifiable;

class Commercial extends Media implements Classifiable {

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

}
