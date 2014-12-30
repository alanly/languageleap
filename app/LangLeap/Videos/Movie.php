<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;
use LangLeap\Videos\Media;

class Movie extends Media implements Billable {

	function __construct($attributes = [])
	{
		$this->timestamps = false;
		$this->fillable = array_merge(parent::getFillable(), ['director', 'actor', 'genre']);
		$this->rules = array_merge(parent::getRules(), []);
		parent::__construct($attributes);
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

	public function toResponseArray()
	{
		$movie = $this;
		$videos = $movie->videos()->get();
		$videos_array = array();

		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray();
		}
		
		return array(
			'id' 			=> $movie->id,
			'name' 			=> $movie->name,
			'description' 	=> $movie->description,
			'director' 		=> $movie->director,
			'actor' 		=> $movie->actor,
			'genre' 		=> $movie->genre,
			'videos' 		=> $videos_array,
			'level' 		=> parent::level()->get(["description"]),
		);
	}

}
