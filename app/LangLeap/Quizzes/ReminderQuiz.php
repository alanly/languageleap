<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Quang Tran <tran.quang@live.com>
 */
class ReminderQuiz extends QuizCategory {

	public $timestamps = false;
	protected $fillable = ['attempted'];
	
	public function quiz()
	{
		return $this->morphOne('LangLeap\Quizzes\Quiz', 'category');
	}
	
	public function questionAnswered()
	{
		if(!$this->attempted)
		{
			$this->attempted = true;
			$this->save();
		}
	}
	
	public function toResponseArray()
	{
		return ['attempted' => $this->attempted];
	}

}
