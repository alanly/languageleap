<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class VideoQuiz extends Eloquent {

	public $timestamps = false;
	protected $fillable = ['video_id'];
	
	public function quiz()
	{
		return $this->morphMany('LangLeap\Quizzes\Quiz', 'category');
	}
	
	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');
	}
	
	public function toResponseArray()
	{
		return ['video' => $this->video()->toResponseArray()];
	}

}
