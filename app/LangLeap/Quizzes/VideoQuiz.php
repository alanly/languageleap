<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Quang Tran <tran.quang@live.com>
 */
class VideoQuiz extends QuizCategory {

	public $timestamps = false;
	protected $fillable = ['video_id'];
	
	public function quiz()
	{
		return $this->morphOne('LangLeap\Quizzes\Quiz', 'category');
	}
	
	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');
	}
	
	public function questionAnswered()
	{
		// Do nothing
	}
	
	public function toResponseArray()
	{
		return ['video' => $this->video()->toResponseArray()];
	}

}
