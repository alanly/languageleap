<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Commercial extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description'];
	
	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

	public function toResponseArray($comm)
	{
		$videos = $comm->videos()->get();
		$videos_array = array();
		foreach($videos as $video){
			$videos_array[] = $video->toResponseArray($video);
		}
		return array(
			'id' => $comm->id,
			'name' => $comm->name,
			'description' => $comm->description,
			'videos' => $videos_array,
		);
	}
}
