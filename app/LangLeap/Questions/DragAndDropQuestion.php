<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DragAndDropQuestion extends QuestionType {

	public    $timestamps = false;
	protected $table      = 'drag_and_drop_questions';
	protected $fillable   = ['sentence'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function question()
	{
		return $this->sentence;
	}

	public function type()
	{
		return QuestionTypes::DragAndDrop;
	}

	public function isBankable()
	{
		return false;
	}
}
