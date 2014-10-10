<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

class Commercial extends ValidatedModel {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description'];
	protected $rules      = ['name' => 'required'];
	

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
		);
	}
}
