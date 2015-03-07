<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ReminderQuiz extends Eloquent {

	public $timestamps = false;
	protected $fillable = ['attempted'];
	
	public function quiz()
	{
		return $this->morphMany('LangLeap\Quizzes\Quiz', 'category');
	}
	
	public function toResponseArray()
	{
		return ['attempted' => $this->attempted];
	}

}
