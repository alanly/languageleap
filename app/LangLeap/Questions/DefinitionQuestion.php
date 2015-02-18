<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DefinitionQuestion extends QuestionType {

	public    $timestamps = false;
	protected $table      = 'definition_questions';
	protected $fillable   = ['question', 'definition_id'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function question()
	{
		return $this->question;
	}

	public function type()
	{
		return QuestionTypes::MultipleChoice;
	}

	public function isBankable()
	{
		return true;
	}
}
